<?php

namespace Me_Qr\Services\AdminPages\Modules;

use Me_Qr\Services\Auth\MeQrUserService;
use Me_Qr\Services\File\PathService;
use Me_Qr\Services\File\QrFileManager;
use Me_Qr\Services\Url\UrlService;

class MeQrGutenbergService
{
    private MeQrUserService $meQrUserService;
    private QrFileManager $qrFileManager;

    public function __construct(
	    MeQrUserService $meQrUserService,
		QrFileManager $qrFileManager
    ) {
        $this->meQrUserService = $meQrUserService;
        $this->qrFileManager = $qrFileManager;
    }

    public function registerQrMetaBox(): void
    {
        if (UrlService::isGutenbergPage()) {
            $this->register_sidebar_styles();
            $this->register_sidebar_scripts();
        }
    }

    private function register_sidebar_styles(): void
    {
        wp_enqueue_style(
            'me_qr_loading_module_style',
            PathService::buildCssUrl('modules/loading-module')
        );
        add_action('admin_enqueue_scripts', function() {
            wp_enqueue_style(
                'me_qr_gutenberg_block_style',
                PathService::buildCssUrl('admin/gutenberg/qr-meta-box')
            );
        });
    }

    private function register_sidebar_scripts(): void
    {
        add_action('admin_enqueue_scripts', function() {
            wp_enqueue_script('me_qr_npm_script', PathService::buildFileUrlPath('frontend/build/index.js'),
                [ 'wp-edit-post', 'wp-i18n' ]
            );

            $currentPostId = get_the_ID();
            $isQrsExists = (int) $this->qrFileManager->isQrsExists($currentPostId);
            $isPermanentUser = $this->meQrUserService->checkPermanentUser() ? 'true' : 'false';
			$jsVars = "let isQrsExists = $isQrsExists; let isPermanentUser = $isPermanentUser;";

            wp_add_inline_script('me_qr_npm_script', $jsVars, 'before');
            wp_set_script_translations('me_qr_npm_script', 'me-qr', ME_QR_LANG_PATH);
        });
    }
}
