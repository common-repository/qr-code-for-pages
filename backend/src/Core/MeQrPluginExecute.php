<?php

namespace Me_Qr\Core;

use Me_Qr\Controller\AccountController;
use Me_Qr\Controller\AdminPages\SettingsPageController;
use Me_Qr\Controller\UpdatePluginDataController;
use Me_Qr\Controller\QrCodeLinkController;
use Me_Qr\Core\Hooks\PluginCoreInitializer;
use Me_Qr\Core\Hooks\PluginDeactivateInitializer;
use Me_Qr\Core\Hooks\PluginInstallInitializer;
use Me_Qr\Services\ErrorHandler\ErrorHandlerService;
use Me_Qr\Services\Url\WpCoreRequest;
use Throwable;

class MeQrPluginExecute
{
    private ErrorHandlerService $errorHandlerService;
    private PluginInstallInitializer $pluginInstallInitializer;
    private PluginDeactivateInitializer $pluginDeactivateInitializer;
    private PluginCoreInitializer $pluginCoreInitializer;
    private QrCodeLinkController $qrCodeLinkController;
    private AccountController $accountController;
    private SettingsPageController $settingsPageController;
    private UpdatePluginDataController $updatePluginDataController;

    public function __construct(
        ErrorHandlerService $errorHandlerService,
        PluginInstallInitializer $pluginInstallInitializer,
        PluginDeactivateInitializer $pluginDeactivateInitializer,
        PluginCoreInitializer $pluginCoreInitializer,
        QrCodeLinkController $qrCodeLinkController,
        AccountController $accountController,
        SettingsPageController $settingsPageController,
        UpdatePluginDataController $updatePluginDataController
    ) {
        $this->errorHandlerService = $errorHandlerService;
        $this->pluginInstallInitializer = $pluginInstallInitializer;
        $this->pluginDeactivateInitializer = $pluginDeactivateInitializer;
        $this->pluginCoreInitializer = $pluginCoreInitializer;
        $this->qrCodeLinkController = $qrCodeLinkController;
        $this->accountController = $accountController;
        $this->settingsPageController = $settingsPageController;
        $this->updatePluginDataController = $updatePluginDataController;
    }

    public function execute(): void
    {
        $this->installation();
        $this->deactivation();

        add_action('init', function() {
            $this->languages();
            $this->core();
        });

        add_action('rest_api_init', function() {
            $this->api();
        });
    }

    public function installation(): void
    {
        register_activation_hook(ME_QR_FILE_PATH, function() {
            if (!WpCoreRequest::isInstallRequest()) {
                return;
            }

            try {
                $this->pluginInstallInitializer->handle();
            } catch (Throwable $e) {
                $this->errorHandlerService->handleException($e);
                die($e->getMessage());
            }
        });
    }

    public function deactivation(): void
    {
        register_deactivation_hook(ME_QR_FILE_PATH, function() {
            try {
                $this->pluginDeactivateInitializer->handle();
            } catch (Throwable $e) {
                $this->errorHandlerService->handleException($e);
            }
        });
    }

    public function core(): void
    {
        try {
            $this->pluginCoreInitializer->execute();
        } catch (Throwable $e) {
            $this->errorHandlerService->handleException($e);
        }
    }

    public function api(): void
    {
        try {
            $this->qrCodeLinkController->register_routes();
            $this->accountController->register_routes();
            $this->settingsPageController->register_routes();
            $this->updatePluginDataController->register_routes();
        } catch (Throwable $e) {
            $this->errorHandlerService->handleException($e);
        }
    }

    public function languages(): void
    {
        load_plugin_textdomain(
            ME_QR_TEXT_DOMAIN,
            false,
            dirname(plugin_basename(ME_QR_FILE_PATH)) . '/languages'
        );
    }
}
