<?php

namespace Me_Qr\Services\AdminPages\Modules;

use Me_Qr\Services\Auth\MeQrUserService;
use Me_Qr\Services\File\QrFileManager;
use Me_Qr\Services\Packages\Template\TemplateManager;
use Me_Qr\Services\Url\UrlService;

class MeQrWoocommerceService
{
	private MeQrUserService $meQrUserService;
    private TemplateManager $templateManager;
    private QrFileManager $qrFileManager;

    public function __construct(
	    MeQrUserService $meQrUserService,
        TemplateManager $templateManager,
        QrFileManager $qrFileManager
    ) {
        $this->meQrUserService = $meQrUserService;
        $this->templateManager = $templateManager;
        $this->qrFileManager = $qrFileManager;
    }

    public function registerQrMetaBox(): void
    {
        if (!UrlService::isWoocommercePage()) {
            return;
        }

        add_action('add_meta_boxes', function() {
            add_meta_box(
                'me-qr-code-meta-box',
                esc_html__('Qr Code', 'me-qr'),
                [$this, 'qrCodeMetaBoxContent'],
                ['product'],
                'side',
                'low',
            );
        });
    }

    public function qrCodeMetaBoxContent($post): void
    {
        $data = [
            'postId' => $post->ID,
            'isQrExist' => $this->qrFileManager->isQrsExists($post->ID),
	        'isPermanentUser' => $this->meQrUserService->checkPermanentUser(),
        ];

        $this->templateManager->include('admin/woocommerce/me-qr-wc-meta-box-template', $data);
    }
}
