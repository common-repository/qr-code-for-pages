<?php

namespace Me_Qr\Services\Loggers\TelegramLog;

class TelegramLogSettings
{
    public static function isLoggingAllowed(): bool
    {
        $value = get_option(ME_QR_TG_LOGGING_PARAM, null);
        if (!$value) {
            return ME_QR_IS_SENDING_TG_LOGS_DEFAULT;
        }

        return $value === 'true';
    }

    public static function isDefinedLoggingOption(): bool
    {
        return get_option(ME_QR_TG_LOGGING_PARAM, null) !== null;
    }

    public static function setLoggingOptionValue(bool $value): void
    {
        $valueStr = var_export($value, true);
        $option = get_option(ME_QR_TG_LOGGING_PARAM);
        if ($option === $valueStr) {
            return;
        }

        if ($option) {
            update_option(ME_QR_TG_LOGGING_PARAM, $valueStr);
        } else {
            add_option(ME_QR_TG_LOGGING_PARAM, $valueStr);
        }
    }

    public static function deleteLoggingOption(): void
    {
        delete_option(ME_QR_TG_LOGGING_PARAM);
    }
}