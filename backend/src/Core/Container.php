<?php

namespace Me_Qr\Core;

use Me_Qr\Exceptions\ContainerException;
use Me_Qr_Vendor\Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;

class Container implements ContainerInterface
{
    private array $entries = [];

    /**
     * @throws ContainerException
     * @throws ReflectionException
     */
    public function get(string $id)
    {
        if ($this->has($id)) {
            $entry = $this->entries[$id];

            return $entry($this);
        }

        return $this->resolve($id);
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    public function set(string $id, callable $concrete): void
    {
        $this->entries[$id] = $concrete;
    }

    /**
     * @throws ReflectionException
     * @throws ContainerException
     */
    public function resolve(string $id)
    {
        $reflectionClass = new ReflectionClass($id);
        if (!$reflectionClass->isInstantiable()) {
            throw new ContainerException("Class $id is not instantiable");
        }

        $constructor = $reflectionClass->getConstructor();
        if (!$constructor) {
            return new $id;
        }

        $parameters = $constructor->getParameters();
        if (!$parameters) {
            return new $id;
        }

        $dependencies = array_map(function(\ReflectionParameter $param) use ($id) {
            $name = $param->getName();
            $type = $param->getType();
            if (!$type) {
                throw new ContainerException(
                    "Failed to resolve class $id because param $name is missing a type hint"
                );
            }
            if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
                return $this->get($type->getName());
            }

            throw new ContainerException(
                "Failed to resolve class $id because invalid param $name"
            );
        }, $parameters);

        return $reflectionClass->newInstanceArgs($dependencies);
    }
}