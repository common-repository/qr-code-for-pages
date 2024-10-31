<?php

namespace Me_Qr\Services\PluginSettings\Backup;

use Me_Qr\Exceptions\InternalDataException;
use Me_Qr\Repository\PluginSettingsRepository;
use Me_Qr\Services\Auth\AuthTokenService;
use Me_Qr\Services\Packages\Validator\Exceptions\ValidationException;
use Me_Qr\Services\PluginSettings\Backup\DTO\PluginBackupDateDTOBuilder;
use Me_Qr\Services\PluginSettings\DTO\SettingsPageDTOBuilder;
use Me_Qr\Services\PluginSettings\PluginSettingsService;
use Me_Qr\Services\Requests\PluginSettingsRequests;

class PluginBackupService
{
    private PluginSettingsService $pluginSettingsService;
    private PluginBackupInfoService $backupInfoService;
    private PluginSettingsRequests $pluginSettingsRequests;
    private PluginBackupDateDTOBuilder $pluginBackupDateDTOBuilder;
    private SettingsPageDTOBuilder $settingsPageDTOBuilder;

    public function __construct(
        PluginSettingsService $pluginSettingsService,
        PluginBackupInfoService $backupInfoService,
        PluginSettingsRequests $pluginSettingsRequests,
        PluginBackupDateDTOBuilder $pluginBackupDateDTOBuilder,
        SettingsPageDTOBuilder $settingsPageDTOBuilder
    ) {
        $this->pluginSettingsService = $pluginSettingsService;
        $this->backupInfoService = $backupInfoService;
        $this->pluginSettingsRequests = $pluginSettingsRequests;
        $this->pluginBackupDateDTOBuilder = $pluginBackupDateDTOBuilder;
        $this->settingsPageDTOBuilder = $settingsPageDTOBuilder;
    }

    /**
     * @throws InternalDataException
     */
    public function exportSettings(): string
    {
        $pluginSettings = PluginSettingsRepository::findRequiredEntity();

        $responseData = $this->pluginSettingsRequests->createExportRequest(
	        AuthTokenService::getReqAuthToken(),
            $pluginSettings->getQrBlockClass(),
            $pluginSettings->getQrImgClass(),
            $pluginSettings->isFileLogging(),
            $pluginSettings->isTgLogging(),
        );

        $backupDateDTO = $this->pluginBackupDateDTOBuilder->buildByArrayData($responseData->getData());
        $backupDateUTC = $backupDateDTO->getBackupDateUTC() ?? esc_html__('never', 'me-qr');
        $this->backupInfoService->saveExportDate($backupDateUTC);

        return $backupDateDTO->getBackupDate();
    }

    /**
     * @throws InternalDataException
     */
    public function importSettings(): void
    {
        $responseData = $this->pluginSettingsRequests->createImportRequest(AuthTokenService::getReqAuthToken());
        try {
            $settingsPageDTO = $this->settingsPageDTOBuilder->buildByRequestDate($responseData->getData());
        } catch (ValidationException $e) {
            throw new InternalDataException('Error building imported data: ' . $e->getMessage());
        }

        $this->pluginSettingsService->saveSettings($settingsPageDTO);
        $this->backupInfoService->saveCurrentImportDate();

        $backupDateDTO = $this->pluginBackupDateDTOBuilder->buildByArrayData($responseData->getData());
        $this->backupInfoService->saveExportDate($backupDateDTO->getBackupDateUTC());
    }
}