<?php

namespace Me_Qr\Services\Url;

class DevService
{
    public static function isDevMode(): bool
    {
        if (ME_QR_APP_ENV === 'dev') {
            return true;
        }
        if (ServerService::isLocalhost()) {
            return true;
        }
        if (!ServerService::isHttpsProtocol()) {
            return true;
        }


        return false;
    }
}