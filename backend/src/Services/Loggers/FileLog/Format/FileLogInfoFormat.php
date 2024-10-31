<?php

namespace Me_Qr\Services\Loggers\FileLog\Format;

class FileLogInfoFormat
{
    public function createByMessage(string $message): string
    {
        return ME_QR_ERROR_LOG_PREFIX . " plugin info| $message";
    }
}