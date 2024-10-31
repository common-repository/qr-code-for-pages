<?php

namespace Me_Qr\Services\Packages\Validator\Assert\Models;

class ValidationType
{
    private string $title;

    private string $namespace;

    private array $options;

    public function __construct(string $title, string $namespace, array $options)
    {
        $this->title = $title;
        $this->namespace = $namespace;
        $this->options = $options;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}