<?php

namespace Me_Qr\Services\Loggers\FileLog;

use Me_Qr\Repository\PluginSettingsRepository;

class FileLogService
{
    public function writeToLog(string $message): void
    {
        if (!$this->isWriteAllowed()) {
            return;
        }

        error_log($message);
    }

    public function isWriteAllowed(): bool
    {
        if (defined('ME_QR_ENABLE_FILE_LOG_PARAM' && ME_QR_ENABLE_FILE_LOG_PARAM !== null)) {
            if (ME_QR_ENABLE_FILE_LOG_PARAM === true) {
                return true;
            }
            if (ME_QR_ENABLE_FILE_LOG_PARAM === false) {
                return false;
            }
        }

        $pluginSettings = PluginSettingsRepository::findEntity();
        if ($pluginSettings) {
            return $pluginSettings->isFileLogging();
        }

        return WP_DEBUG_LOG === true;
    }
}