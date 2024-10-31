<?php

namespace Me_Qr\Services\File;

class PathService
{
    public static function buildFileUrlPath(string $uri): string
    {
        return ME_QR_APP_URL . $uri;
    }

    public static function buildFilePath(string $path): string
    {
        return ME_QR_APP_PATH . $path;
    }

    public static function buildCssUrl(string $path): string
    {
        return self::buildFileUrlPath(ME_QR_CSS_PATH . $path . '.css');
    }

    public static function buildJsUrl(string $path): string
    {
        return self::buildFileUrlPath(ME_QR_JS_PATH . $path . '.js');
    }

    public static function buildTemplatePath(string $path): string
    {
        return self::buildFilePath(ME_QR_TEMPLATE_PATH . $path . '.php');
    }
}
