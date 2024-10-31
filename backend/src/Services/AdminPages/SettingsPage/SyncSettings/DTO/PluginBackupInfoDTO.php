<?php

namespace Me_Qr\Services\AdminPages\SettingsPage\SyncSettings\DTO;

use JsonSerializable;
use Me_Qr\Services\Validation\Assert\Constraints as MeQrAssert;

/**
 * @MeQrAssert(translate="true")
 */
class PluginBackupInfoDTO implements JsonSerializable
{
    /**
     * @MeQrAssert\NotBlank(message="Wordpress user id not specified")
     * @MeQrAssert\Type(type="numeric")
     */
    private $wpUserId;

    /**
     * @MeQrAssert\NotBlank(message="Auth token not specified")
     * @MeQrAssert\Type(type="string")
     */
    private $siteUrl;

    /**
     * @MeQrAssert\NotBlank(message="Backup date-time not specified")
     * @MeQrAssert\DateTime()
     */
    private $backupDatetimeUtc;

    public function __construct($wpUserId, $siteUrl, $backupDatetimeUtc)
    {
        $this->wpUserId = $wpUserId;
        $this->siteUrl = $siteUrl;
        $this->backupDatetimeUtc = $backupDatetimeUtc;
    }

    public function getWpUserId(): int
    {
        return $this->wpUserId;
    }

    public function getSiteUrl(): string
    {
        return $this->siteUrl;
    }

    public function getBackupDatetime(string $returnFormat = 'Y-m-d H:i:s'): string
    {
        return get_date_from_gmt($this->backupDatetimeUtc, $returnFormat);
    }

    public function getBackupDatetimeUtc(): string
    {
        return $this->backupDatetimeUtc;
    }

    public function jsonSerialize(): array
    {
        return [
            PluginBackupInfoFields::USER_ID_KEY => $this->getWpUserId(),
            PluginBackupInfoFields::SITE_URL_KEY => $this->getSiteUrl(),
            PluginBackupInfoFields::BACKUP_DATE_TIME_KEY => $this->getBackupDatetimeUtc(),
        ];
    }
}