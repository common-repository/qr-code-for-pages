<?php

namespace Me_Qr\Services\Url;

class WpCoreRequest
{
    public static function isInstallRequest(): bool
    {
        $uri = sanitize_url($_SERVER['REQUEST_URI']);

        $needleArr = ['action=activate', 'plugin='];
        foreach ($needleArr as $needle) {
            if (!str_contains($uri, $needle)) {
                return false;
            }
        }

        return true;
    }
}