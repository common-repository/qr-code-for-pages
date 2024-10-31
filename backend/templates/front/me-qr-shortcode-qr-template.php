<?php

use Me_Qr\Services\File\PathService;
use Me_Qr\Services\Packages\Template\TemplateParams;
use Me_Qr\Services\QrCode\Loading\Provider\DTO\OneQrFormatProviderDTO;
use Me_Qr\Services\Shortcodes\QrPageShortcode\DTO\ShortcodeDataDTO;

return static function (TemplateParams $params): void
{
    wp_enqueue_style('me_qr_front_block_style', PathService::buildCssUrl('front/qr-shortcode-box'));

    /* @var $qrCodeDTO OneQrFormatProviderDTO */
    $qrCodeDTO = $params->getReq('qrCodeDTO');
    /* @var $shortcodeDTO ShortcodeDataDTO */
    $shortcodeDTO = $params->getReq('shortcodeDTO');

    ?>
        <div class="me-qr-code-box <?php echo esc_attr($shortcodeDTO->getQrBlockClass()); ?>">
            <img src="<?php echo esc_url($qrCodeDTO->getQrCode()); ?>"
                 alt="qr_code_img"
                 class="me-qr-img <?php echo esc_attr($shortcodeDTO->getQrImgClass()); ?>"
            />
        </div>
    <?php
};
