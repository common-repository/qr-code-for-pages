<?php

use Me_Qr\Entity\MeQrUserEntity;
use Me_Qr\Services\Packages\Template\TemplateParams;

return function(TemplateParams $params): void
{
    /** @var MeQrUserEntity $user */
    $user = $params->getReq('meQrUser');
    $isPermanentUser = $user->isPermanentUser();
    $isPremiumUser = $user->isUserPremium();
    $pricingPageLink = $params->get('pricingPageLink');
    $premiumPageLink = $params->get('premiumPageLink');

    ?>
    <div class="me-qr-setting">
        <div class="me-qr-setting-header-box">
            <div class="me-qr-setting-header me-qr-setting-header-prem">
                <?php esc_html_e('Premium features', 'me-qr'); ?>
            </div>
        </div>

        <div class="me-qr-setting-content">
            <?php if ($isPremiumUser) { ?>
                <div class="me-qr-setting-desc me-qr-setting-desc-gold">
                    <p><?php esc_html_e('You have activated a premium subscription', 'me-qr'); ?>.</p>
                    <p><?php esc_html_e('When scanning a QR code, users will not see ads', 'me-qr'); ?>.</p>
                </div>

                <div class="me-qr-setting-input-box">
                    <div class="me_qr_sht_block_class_input">
                        <?php esc_html_e('Subscription management', 'me-qr'); ?>
                    </div>
                    <a href="<?php $isPermanentUser ? esc_html_e($premiumPageLink) : esc_html_e($pricingPageLink); ?>"
                       target="_blank"
                       class="me-qr-link-btn me-qr-link-btn-gold"
                    >
                        <?php esc_html_e('View subscription details', 'me-qr'); ?>
                    </a>
                </div>
            <?php } else { ?>
                <div class="me-qr-setting-desc me-qr-setting-desc-note">
                    <p><?php esc_html_e('You have a free plan', 'me-qr'); ?>.</p>
                    <p><?php esc_html_e('When scanning a QR code, users will see ads', 'me-qr'); ?>.</p>
                    <p><?php esc_html_e('Purchase our subscription and use QR Codes without ads', 'me-qr'); ?>.</p>
                </div>

                <div class="me-qr-setting-input-box">
                    <div class="me_qr_sht_block_class_input">
                        <?php esc_html_e('Purchasing a subscription', 'me-qr'); ?>
                    </div>
                    <a href="<?php $isPermanentUser ? esc_html_e($premiumPageLink) : esc_html_e($pricingPageLink); ?>"
                       target="_blank"
                       class="me-qr-link-btn"
                    >
                        <?php esc_html_e('See offers', 'me-qr'); ?>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
};
