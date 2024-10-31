<?php

namespace Me_Qr\Services\PluginSettings;

use Me_Qr\Entity\PluginSettingsEntity;
use Me_Qr\Repository\PluginSettingsRepository;
use Me_Qr\Services\PluginSettings\DTO\SettingsPageDTO;

class PluginSettingsService
{
    public function createDefaultSettings(): PluginSettingsEntity
    {
        $pluginSettings = PluginSettingsRepository::buildEntity(
            null,
            null,
            ME_QR_IS_WRITING_PLUGIN_LOGS_DEFAULT,
            ME_QR_IS_SENDING_TG_LOGS_DEFAULT,
        );
        PluginSettingsRepository::saveEntity($pluginSettings);

        return $pluginSettings;
    }

    public function saveSettings(SettingsPageDTO $data): PluginSettingsEntity
    {
        $pluginSettings = PluginSettingsRepository::findEntity();
        if (!$pluginSettings) {
            $pluginSettings = new PluginSettingsEntity();
        }

        $pluginSettings->setQrBlockClass($data->getQrBlockClass());
        $pluginSettings->setQrImgClass($data->getQrImgClass());
        $pluginSettings->setIsFileLogging($data->getFileLoggingValue());
        $pluginSettings->setIsTgLogging($data->getTgLoggingValue());

        PluginSettingsRepository::saveEntity($pluginSettings);

        return $pluginSettings;
    }
}