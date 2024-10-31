<?php

namespace Me_Qr\Services\PluginSettings\Backup;

use Me_Qr\Entity\BackupInfoEntity;
use Me_Qr\Repository\BackupInfoRepository;

class PluginBackupInfoService
{
    public function saveDefault(): BackupInfoEntity
    {
        $pluginBackupInfo = BackupInfoRepository::buildEntity(null, null);
	    BackupInfoRepository::saveEntity($pluginBackupInfo);

        return $pluginBackupInfo;
    }

    public function saveExportDate(?string $exportDate): BackupInfoEntity
    {
        $pluginBackupInfo = BackupInfoRepository::findEntity();

        $pluginBackupInfo->setExportDate($exportDate);
	    BackupInfoRepository::saveEntity($pluginBackupInfo);

        return $pluginBackupInfo;
    }

    public function saveCurrentImportDate(): BackupInfoEntity
    {
        $pluginBackupInfo = BackupInfoRepository::findEntity();
        $pluginBackupInfo->setImportDate(current_time('Y-m-d H:i:s', true));

	    BackupInfoRepository::saveEntity($pluginBackupInfo);

        return $pluginBackupInfo;
    }
}