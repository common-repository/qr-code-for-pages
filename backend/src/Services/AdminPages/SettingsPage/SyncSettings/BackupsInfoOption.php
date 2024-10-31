<?php

namespace Me_Qr\Services\AdminPages\SettingsPage\SyncSettings;

use Me_Qr\Services\AdminPages\SettingsPage\SyncSettings\DTO\PluginBackupInfoDTO;
use Me_Qr\Services\AdminPages\SettingsPage\SyncSettings\DTO\PluginBackupInfoDTOBuilder;
use Me_Qr\Services\AdminPages\SettingsPage\SyncSettings\DTO\PluginBackupInfoFields;
use Me_Qr\Services\ErrorHandler\ErrorHandlerService;
use Me_Qr\Services\UserRegistration\MeQrUserOptionService;
use Throwable;

class BackupsInfoOption
{
    private PluginBackupInfoDTOBuilder $pluginBackupInfoDTOBuilder;
    private ErrorHandlerService $errorHandlerService;

    public function __construct(
        PluginBackupInfoDTOBuilder $pluginBackupInfoDTOBuilder,
        ErrorHandlerService $errorHandlerService
    ) {
        $this->pluginBackupInfoDTOBuilder = $pluginBackupInfoDTOBuilder;
        $this->errorHandlerService = $errorHandlerService;
    }

    public function isBackupsExists(): bool
    {
        return get_option(ME_QR_BACKUPS_DATA_OPTION_KEY, null) !== null;
    }

    /**
     * @return PluginBackupInfoDTO[]
     */
    public function getAllBackups(): array
    {
        $resultArr = [];
        $backupInfoJson = get_option(ME_QR_BACKUPS_DATA_OPTION_KEY, null);
        if (!$backupInfoJson) {
            return $resultArr;
        }

        try {
            $backupInfoArr = json_decode($backupInfoJson, true);
            if (!$backupInfoArr) {
                return $resultArr;
            }

            foreach ($backupInfoArr as $backupInfo) {
                $resultArr[] = $this->pluginBackupInfoDTOBuilder->build(
                    $backupInfo[PluginBackupInfoFields::USER_ID_KEY] ?? null,
                    $backupInfo[PluginBackupInfoFields::SITE_URL_KEY] ?? null,
                    $backupInfo[PluginBackupInfoFields::BACKUP_DATE_TIME_KEY] ?? null,
                );
            }
        } catch (Throwable $e) {
            $this->errorHandlerService->writeErrorToLog(
                'Error getting backup plugin data from the database: ' . $e->getMessage()
            );
        }

        return $resultArr;
    }

    public function getMainBackup(): ?PluginBackupInfoDTO
    {
        $wpUserId = MeQrUserOptionService::getWpUserIdOption();
        if (!$wpUserId) {
            return null;
        }
        foreach ($this->getAllBackups() as $backup) {
            if ($backup->getWpUserId() === $wpUserId) {
                return $backup;
            }
        }

        return null;
    }

    /**
     * @param PluginBackupInfoDTO[] $backupInfoDTO
     */
    public function setAllBackups(array $backupInfoDTO): void
    {
        try {
            $newBackupInfoJson = json_encode($backupInfoDTO);
            if (!$newBackupInfoJson) {
                return;
            }
            $oldBackupInfo = $this->getAllBackups();
            if ($newBackupInfoJson === json_encode($oldBackupInfo)) {
                return;
            }

            if ($this->isBackupsExists()) {
                update_option(ME_QR_BACKUPS_DATA_OPTION_KEY, $newBackupInfoJson);
            } else {
                add_option(ME_QR_BACKUPS_DATA_OPTION_KEY, $newBackupInfoJson);
            }
        } catch (Throwable $e) {
            $this->errorHandlerService->writeErrorToLog(
                'Error writing backup plugin data to the database: ' . $e->getMessage()
            );
        }
    }

    public function delete(): void
    {
        delete_option(ME_QR_BACKUPS_DATA_OPTION_KEY);
    }
}