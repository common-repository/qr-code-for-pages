<?php

namespace Me_Qr\Services\PluginSettings\Backup\DTO;

use Me_Qr\Exceptions\InternalDataException;
use Me_Qr\Services\Packages\Validator\MeQrValidator;
use Me_Qr\Services\PluginSettings\PluginSettingsOptions;

class PluginBackupDateDTOBuilder
{
    private MeQrValidator $meQrValidator;

    public function __construct(MeQrValidator $meQrValidator)
    {
        $this->meQrValidator = $meQrValidator;
    }

    /**
     * @throws InternalDataException
     */
    public function build($backupDate): PluginBackupDateDTO
    {
        $dto = new PluginBackupDateDTO($backupDate);
        $exceptions = $this->meQrValidator->validate($dto);
        if ($exceptions->isExceptions()) {
            throw new InternalDataException($exceptions->getExceptionString());
        }

        return $dto;
    }

    /**
     * @throws InternalDataException
     */
    public function buildByArrayData(array $date): PluginBackupDateDTO
    {
        return $this->build(
            $date[PluginSettingsOptions::BACKUP_DATE_KEY] ?? null,
        );
    }
}