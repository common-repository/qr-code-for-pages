<?php

use Me_Qr\Entity\MeQrUserEntity;
use Me_Qr\Services\File\PathService;
use Me_Qr\Services\Packages\Template\TemplateParams;

return function(TemplateParams $params): void
{
    /** @var MeQrUserEntity $user */
    $user = $params->getReq('meQrUser');

    ?>
    <div class="me-qr-setting">
        <div class="me-qr-account-header-box">
            <div class="me-qr-account-header">
                <?php esc_html_e('Me-QR Account', 'me-qr'); ?>
            </div>
        </div>

        <div class="me-qr-setting-content">
            <div class="me-qr-setting-desc">
                <p>
                    <?php esc_html_e('You are logged in as an Me-QR user:', 'me-qr'); ?>
                    <span class="me-qr-text-bold"> <?php esc_html_e($user->getUsername()); ?></span>
                </p>
                <p class="me-qr-mt-1">
                    <?php esc_html_e('You can change your account by logging out of it', 'me-qr'); ?>.
                </p>
                <p>
                    <?php esc_html_e('Generated QR codes and plugin settings will remain unchanged', 'me-qr'); ?>.
                </p>
            </div>
            <div class="me-qr-btn-box">
                <div class="me-qr-btn me-qr-btn-1 me-qr-logout-btn">
                    <?php esc_html_e('Log out of your account', 'me-qr'); ?>
                </div>

                <?php $this->include('modules/loading-module', [
                    'id' => 'me_qr_logout_loader',
                ]); ?>
            </div>
        </div>
    </div>
    <?php

    wp_enqueue_script(
        'me_qr_admin_account_logout_script',
        PathService::buildJsUrl('admin/pages/admin-settings/AccountLogout')
    );
    wp_set_script_translations('me_qr_admin_account_logout_script', 'me-qr', ME_QR_LANG_PATH);
};
