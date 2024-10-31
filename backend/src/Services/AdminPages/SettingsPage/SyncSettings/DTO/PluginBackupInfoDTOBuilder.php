<?php

namespace Me_Qr\Services\AdminPages\SettingsPage\SyncSettings\DTO;

use Me_Qr\Services\Validation\Exceptions\ValidationException;
use Me_Qr\Services\Validation\MeQrValidator;

class PluginBackupInfoDTOBuilder
{
    private MeQrValidator $meQrValidator;

    public function __construct(MeQrValidator $meQrValidator)
    {
        $this->meQrValidator = $meQrValidator;
    }

    /**
     * @throws ValidationException
     */
    public function build($wpUserId, $siteUrl, $backupDatetimeUtc): PluginBackupInfoDTO
    {
        $pluginBackupInfoDTO = new PluginBackupInfoDTO($wpUserId, $siteUrl, $backupDatetimeUtc);
        $this->validate($pluginBackupInfoDTO);

        return $pluginBackupInfoDTO;
    }

    /**
     * @return PluginBackupInfoDTO[]
     * @throws ValidationException
     */
    public function buildByRequestData(array $requestData): array
    {
        $pluginBackupsInfo = [];
        $pluginBackups = $requestData[PluginBackupInfoFields::REQUEST_BACKUPS_KEY] ?? [];

        if ($pluginBackups && is_array($pluginBackups)) {
            foreach ($pluginBackups as $pluginBackup) {
                if (!is_array($pluginBackup)) {
                    continue;
                }

                $pluginBackupsInfo[] = $this->build(
                    $pluginBackup['wpUserId'] ?? null,
                    $pluginBackup['siteUrl'] ?? null,
                    $pluginBackup['backupDatetime'] ?? null,
                );
            }
        }

        return $pluginBackupsInfo;
    }

    /**
     * @throws ValidationException
     */
    private function validate(PluginBackupInfoDTO $pluginBackupInfoDTO): void
    {
        $exceptions = $this->meQrValidator->validate($pluginBackupInfoDTO);
        if ($exceptions->isExceptions()) {
            throw new ValidationException($exceptions->getExceptionString(true));
        }
    }
}