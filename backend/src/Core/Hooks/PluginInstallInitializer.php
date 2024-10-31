<?php

namespace Me_Qr\Core\Hooks;

use Me_Qr\Entity\Options\PluginSettingsOption;
use Me_Qr\Exceptions\InternalDataException;
use Me_Qr\Repository\MeQrUserRepository;
use Me_Qr\Services\Auth\MeQrUserService;
use Me_Qr\Services\PluginSettings\PluginSettingsService;

class PluginInstallInitializer
{
    private MeQrUserService $meQrUserService;
    private PluginSettingsService $pluginSettingsService;

    public function __construct(
        MeQrUserService $meQrUserService,
        PluginSettingsService $pluginSettingsService
    ) {
        $this->meQrUserService = $meQrUserService;
        $this->pluginSettingsService = $pluginSettingsService;
    }

    /**
     * @throws InternalDataException
     */
    public function handle(): void
    {
	    if (!PluginSettingsOption::isExist()) {
		    $this->pluginSettingsService->createDefaultSettings();
	    }

        if (!MeQrUserRepository::findEntity()) {
            $this->meQrUserService->registerSecondaryUser();
        }
    }
}
