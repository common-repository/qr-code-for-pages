<?php

namespace Me_Qr\Services\Url;

class ServerService
{
    public static function isHttpsProtocol(): bool
    {
        return !empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS']);
    }

    public static function isLocalhost(): bool
    {
        $siteUrl = get_site_url();
        if (stripos($siteUrl, 'localhost') !== false) {
            return true;
        }
        if (strpos($siteUrl, '127.0.0.1') !== false) {
            return true;
        }
        if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') {
            return true;
        }

        return false;
    }
}