<?php

namespace Me_Qr\Services\Packages\Template;

use Me_Qr\Services\ErrorHandler\ErrorHandlerService;
use Me_Qr\Services\File\PathService;
use Throwable;

class TemplateManager
{
    private ErrorHandlerService $errorHandlerService;

    public function __construct(ErrorHandlerService $errorHandlerService)
    {
        $this->errorHandlerService = $errorHandlerService;
    }

    public function include(string $path, array $params = []): void
    {
        echo ($this->getTemplateContent($path, $params));
    }

    public function getIncludeString(string $path, array $params = []): string
    {
        return $this->getTemplateContent($path, $params);
    }

    private function getTemplateContent(string $path, array $params = []): string
    {
        try {
            ob_start();
            $templateFunction = include(PathService::buildTemplatePath($path));
            $templateFunction(new TemplateParams($path, $params));

            return ob_get_clean();
        } catch (Throwable $e) {
            $this->errorHandlerService->handleException($e);
            return '';
        }
    }
}
