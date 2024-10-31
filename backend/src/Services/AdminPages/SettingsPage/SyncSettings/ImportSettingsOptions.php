<?php

namespace Me_Qr\Services\AdminPages\SettingsPage\SyncSettings;

class ImportSettingsOptions
{
    public static function getImportDate(): ?string
    {
        $dateTimeUtcOption = get_option(ME_QR_IMPORT_DATE_OPTION_KEY, null);
        if (!$dateTimeUtcOption) {
            return null;
        }

        return get_date_from_gmt($dateTimeUtcOption);
    }

    public static function getImportDateUtc(): ?string
    {
        return get_option(ME_QR_IMPORT_DATE_OPTION_KEY, null);
    }

    public static function setImportDate(?string $value): void
    {
        if (!$value) {
            return;
        }
        $dateTimeUtc = get_gmt_from_date($value);

        $dateTimeUtcOption = get_option(ME_QR_IMPORT_DATE_OPTION_KEY);
        if ($dateTimeUtcOption === $dateTimeUtc) {
            return;
        }

        if ($dateTimeUtcOption) {
            update_option(ME_QR_IMPORT_DATE_OPTION_KEY, $dateTimeUtc);
        } else {
            add_option(ME_QR_IMPORT_DATE_OPTION_KEY, $dateTimeUtc);
        }
    }

    public static function setCurrentImportDate(): void
    {
        self::setImportDate(wp_date('Y-m-d H:i:s'));
    }

    public static function deleteImportDate(): void
    {
        delete_option(ME_QR_IMPORT_DATE_OPTION_KEY);
    }
}