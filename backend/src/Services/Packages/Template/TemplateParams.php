<?php

namespace Me_Qr\Services\Packages\Template;

use Me_Qr\Exceptions\InternalDataException;

class TemplateParams
{
    private string $templatePath;
    private array $params;

    public function __construct(string $templatePath, array $params = [])
    {
        $this->templatePath = $templatePath;
        $this->params = $params;
    }

    public function getTemplatePath(): string
    {
        return $this->templatePath;
    }

    public function all(): array
    {
        return $this->params;
    }

    public function get(string $key, $defaultValue = null)
    {
        return $this->params[$key] ?? $defaultValue;
    }

    /**
     * @throws InternalDataException
     *
     * Use if you need to get a mandatory parameter in the template,
     * without which it is forbidden to copy the code further
     */
    public function getReq(string $key)
    {
        $param = $this->params[$key] ?? null;
        if (!$param) {
            $path = $this->getTemplatePath();
            throw new InternalDataException("Template '$path' rendering error. Required parameter '$key' not found");
        }

        return $param;
    }
}
