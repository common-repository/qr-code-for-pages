<?php

namespace Me_Qr\Core\Hooks;

use Me_Qr\Services\AdminPages\AdminPageManager;
use Me_Qr\Services\AdminPages\Modules\MeQrGutenbergService;
use Me_Qr\Services\AdminPages\Modules\MeQrWoocommerceService;
use Me_Qr\Services\File\PathService;
use Me_Qr\Services\QrCode\Loading\QrUpdateHandler;
use Me_Qr\Services\Shortcodes\ShortcodeManager;

class PluginCoreInitializer
{
    private AdminPageManager $adminPageManager;
    private ShortcodeManager $shortcodeManager;
    private MeQrGutenbergService $meQrGutenbergService;
    private MeQrWoocommerceService $meQrWoocommerceService;
    private QrUpdateHandler $qrUpdateHandler;

    public function __construct(
        AdminPageManager $adminPageManager,
        ShortcodeManager $shortcodeManager,
        MeQrGutenbergService $meQrGutenbergService,
        MeQrWoocommerceService $meQrWoocommerceService,
        QrUpdateHandler $qrUpdateHandler
    ) {
        $this->adminPageManager = $adminPageManager;
        $this->shortcodeManager = $shortcodeManager;
        $this->meQrGutenbergService = $meQrGutenbergService;
        $this->meQrWoocommerceService = $meQrWoocommerceService;
        $this->qrUpdateHandler = $qrUpdateHandler;
    }

    public function execute(): void
    {
        $this->registerGlobalStyles();
        $this->registerGlobalScripts();
        $this->adminPageManager->registerAll();
        $this->shortcodeManager->registerAll();
        $this->meQrGutenbergService->registerQrMetaBox();
        $this->meQrWoocommerceService->registerQrMetaBox();
        $this->qrUpdateHandler->registerPostUpdateHook();
    }

    public function registerGlobalStyles(): void
    {
        // Place to register global styles

        // Admin pages styles
        add_action('admin_enqueue_scripts', function() {
            wp_enqueue_style('me_qr_admin_base_style', PathService::buildCssUrl('me-qr-base'));
        });

        // Front pages styles
        add_action('wp_enqueue_scripts', function() {
            wp_enqueue_style('me_qr_front_base_style', PathService::buildCssUrl('me-qr-base'));
        });
    }

    public function registerGlobalScripts(): void
    {
        // Place to register global scripts

        add_action('admin_enqueue_scripts', function() {
            wp_enqueue_script('me_qr_base_scripts', PathService::buildJsUrl('base/base'));
        });
    }
}
