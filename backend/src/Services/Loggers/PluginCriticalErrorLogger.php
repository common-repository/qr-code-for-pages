<?php

namespace Me_Qr\Services\Loggers;

use Throwable;

class PluginCriticalErrorLogger
{
    private static function writeToLog(string $message): void
    {
        error_log($message);
    }

    private static function handelException(Throwable $exception): string
    {
        $message = 'Message: ' . $exception->getMessage() . ';   ';
        $message .= 'Error file:' . $exception->getFile(). '(' . $exception->getLine() . ')   ';

        return $message;
    }

    public static function logError(string $message): void
    {
        self::writeToLog(ME_QR_ERROR_LOG_PREFIX . $message);
    }

    public static function logCoreException(Throwable $exception): void
    {
        $message = self::handelException($exception);

        self::writeToLog(ME_QR_ERROR_LOG_PREFIX . ' plugin core error| ' . $message);
    }

    public static function logUninstallPluginException(Throwable $exception): void
    {
        $message = self::handelException($exception);

        self::writeToLog(ME_QR_ERROR_LOG_PREFIX . ' plugin uninstall error| ' . $message);
    }
}