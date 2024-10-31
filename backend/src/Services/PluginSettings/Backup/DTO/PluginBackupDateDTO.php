<?php

namespace Me_Qr\Services\PluginSettings\Backup\DTO;

use Me_Qr\Services\Packages\Validator\Assert\Constraints as MeQrAssert;

class PluginBackupDateDTO
{
    /**
     * @MeQrAssert\Type(type="string", message="Backup date must be string type, {{ invalid }} given")
     * @MeQrAssert\DateTime(message="The backup date does not match the date-time format")
     */
    private $backupDate;

    public function __construct($backupDate)
    {
        $this->backupDate = $backupDate;
    }

    public function getBackupDate(): ?string
    {
        if (!$this->backupDate) {
            return null;
        }

        return get_date_from_gmt($this->backupDate);
    }

    public function getBackupDateUTC(): ?string
    {
        return $this->backupDate;
    }
}