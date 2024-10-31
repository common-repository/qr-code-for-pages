<?php

use Me_Qr\Services\File\PathService;
use Me_Qr\Services\Packages\Template\TemplateParams;

return function(TemplateParams $params): void
{
    $loginLink = $params->getReq('loginLink');
    $registrationLink = $params->getReq('registrationLink');

    ?>
    <div class="me-qr-setting">
        <div class="me-qr-account-header-box">
            <div class="me-qr-account-header">
                <?php esc_html_e('Me-QR Account', 'me-qr'); ?>
            </div>
        </div>

        <div class="me-qr-setting-content">
            <div class="me-qr-setting-desc">
                <p><?php esc_html_e(
                    'Create an account on Me-QR, and get more benefits and opportunities', 'me-qr'
                ); ?>.</p>
                <p><?php esc_html_e('By creating an account you:', 'me-qr'); ?></p>
                <p class="me-qr-list">
                    <span class="me-qr-item">
                        <?php esc_html_e('Never lose the generated QR codes', 'me-qr'); ?>
                    </span>
                    <span class="me-qr-item">
                        <?php esc_html_e('You will be able to customize each QR code separately', 'me-qr'); ?>
                    </span>
                    <span class="me-qr-item">
                        <?php esc_html_e(
                            'You will be able to monitor the statistics of the use of QR codes', 'me-qr'
                        ); ?>
                    </span>
                    <span class="me-qr-item">
                        <?php esc_html_e(
                            'You will be able to get rid of ads in scanned QR codes', 'me-qr'
                        ); ?>
                    </span>
                    <span class="me-qr-item">
                        <?php esc_html_e(
                            'You will be able to synchronize the plugin settings with the cloud', 'me-qr'
                        ); ?>
                    </span>
                </p>
            </div>
            <div class="me-qr-btn-box">
                <a href="<?php esc_html_e($loginLink); ?>" target="_blank" class="me-qr-btn">
                    <?php esc_html_e('I already have an account', 'me-qr'); ?>
                </a>

                <a href="<?php esc_html_e($registrationLink); ?>" target="_blank" class="me-qr-btn me-qr-btn-1">
                    <?php esc_html_e('Create a new account', 'me-qr'); ?>
                </a>
            </div>
        </div>
    </div>
    <?php
};
