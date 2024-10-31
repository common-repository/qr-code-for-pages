<?php

use Me_Qr\Services\Packages\Template\TemplateParams;

return function(TemplateParams $params): void
{
    $qrPageLink = $params->getReq('qrPageLink');

    ?>
    <div class="me-qr-setting">
        <div class="me-qr-setting-header-box">
            <div class="me-qr-setting-header">
                <?php esc_html_e('QR-code management', 'me-qr'); ?>
            </div>
        </div>

        <div class="me-qr-setting-content">
            <div class="me-qr-setting-desc">
                <p>
                    <?php esc_html_e(
                        'All QR codes that you generate using the plugin are saved in your account on ME-QR', 'me-qr'
                    ); ?>.
                </p>
                <p>
                    <?php esc_html_e('You can control all available QR codes in one place', 'me-qr'); ?>.
                </p>
                <p>
                    <?php esc_html_e(
                        'You also have the opportunity to change the design of each QR code separately, and view ' .
                        'their scan statistics', 'me-qr'
                    ); ?>.
                </p>
            </div>
            <div class="me-qr-setting-input-box">
                <div class="me_qr_sht_block_class_input">
                    <?php esc_html_e('QR code management', 'me-qr'); ?>
                </div>
                <a href="<?php esc_html_e($qrPageLink); ?>"
                   target="_blank"
                   class="me-qr-link-btn"
                >
                    <?php esc_html_e('Go to QR-codes', 'me-qr'); ?>
                </a>
            </div>
        </div>
    </div>
    <?php
};
