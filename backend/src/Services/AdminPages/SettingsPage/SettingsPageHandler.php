<?php

namespace Me_Qr\Services\AdminPages\SettingsPage;

use Me_Qr\Repository\BackupInfoRepository;
use Me_Qr\Repository\MeQrUserRepository;
use Me_Qr\Repository\PluginSettingsRepository;
use Me_Qr\Services\Packages\Template\TemplateManager;
use Me_Qr\Services\Redirect\MeQrRedirectService;

class SettingsPageHandler
{
    public const PAGE_SLUG = 'me-qr-settings';

    private TemplateManager $templateManager;
    private MeQrRedirectService $meQrRedirectService;

    public function __construct(
        TemplateManager $templateManager,
        MeQrRedirectService $meQrRedirectService
    ) {
        $this->templateManager = $templateManager;
        $this->meQrRedirectService = $meQrRedirectService;
    }

    public function registerPage(): void
    {
        $meQrUser = MeQrUserRepository::findEntity();
        if (!$meQrUser) {
            return;
        }

        add_menu_page(
            esc_html__('QR for pages'),
            esc_html__('QR for pages'),
            'manage_options',
            self::PAGE_SLUG,
            function() use ($meQrUser) {
                $this->templateManager->include('admin/pages/admin-settings/admin-settings-page', [
                    'meQrUser' => $meQrUser,
                    'pluginSettings' => PluginSettingsRepository::findEntity(),
                    'backupInfo' => BackupInfoRepository::findEntity(),
                    'loginLink' => $this->meQrRedirectService->getLoginPageLink(),
                    'registrationLink' => $this->meQrRedirectService->getRegistrationPageLink(),
                    'pricingPageLink' => $this->meQrRedirectService->getPricingPageLink(),
                    'premiumPageLink' => $this->meQrRedirectService->getPremiumPageLink(),
                    'qrPageLink' => $this->meQrRedirectService->getQrPageLink(),
                ]);
            },
            'dashicons-schedule',
            59
        );
    }
}