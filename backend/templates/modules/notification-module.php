<?php

use Me_Qr\Services\File\PathService;
use Me_Qr\Services\Packages\Template\TemplateParams;

return static function(TemplateParams $params): void
{
    wp_enqueue_style(
        'me_qr_notification_module_style',
        PathService::buildCssUrl('modules/notification-module')
   );

    ?>
    <div class="me-qr-notifications-container me-qr-d-none">
        <div class="me-qr-js-notification-prototype me-qr-d-none">
            <div class="me-qr-content"></div>
            <div class="me-qr-close-btn-box">
                <div class="me-qr-close-btn"></div>
            </div>
        </div>
    </div>
    <?php

    wp_enqueue_script(
        'me_qr_notification_module_script',
        PathService::buildJsUrl('modules/notification/MeQrPageNotification')
    );
    wp_set_script_translations('me_qr_notification_module_script', 'me-qr', ME_QR_LANG_PATH);
    wp_enqueue_script(
        'me_qr_reload_notification_module_script',
        PathService::buildJsUrl('modules/notification/MeQrReloadNotification')
    );
};
