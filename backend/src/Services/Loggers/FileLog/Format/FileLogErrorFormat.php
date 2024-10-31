<?php

namespace Me_Qr\Services\Loggers\FileLog\Format;

use Throwable;

class FileLogErrorFormat
{
    public function createByMessage(string $message): string
    {
        return ME_QR_ERROR_LOG_PREFIX . " plugin error| $message";
    }

    public function createByException(Throwable $exception): string
    {
        if (method_exists($exception, 'getContext')) {
            $context = json_encode($exception->getContext()) ?? '{}';
        }

        $result = 'Message: ' . $exception->getMessage() . ', ';
        if (isset($context)) {
            $result .= "$context, ";
        }
        $result .= 'Error file:' . $exception->getFile(). '(' . $exception->getLine() . ')   ';

        return $result;
    }
}