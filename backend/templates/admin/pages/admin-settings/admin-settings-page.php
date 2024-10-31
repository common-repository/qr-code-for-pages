<?php

use Me_Qr\Entity\MeQrUserEntity;
use Me_Qr\Services\File\PathService;
use Me_Qr\Services\Packages\Template\TemplateParams;

return function(TemplateParams $params): void
{
    /* Css styles */
    wp_enqueue_style(
        'me_qr_modal_window_style', PathService::buildCssUrl('modules/modal-window')
    );
    wp_enqueue_style(
        'me_qr_loading_module_style', PathService::buildCssUrl('modules/loading-module')
    );
    wp_enqueue_style(
        'me_qr_admin_settings_page_style', PathService::buildCssUrl('admin/pages/settings/base')
    );

    /** @var MeQrUserEntity $user */
    $user = $params->getReq('meQrUser');
    $nonceKey = wp_create_nonce('wp_rest');

    ?>
    <hr class="wp-header-end me-qr-d-none"/>

    <div class="me-qr-settings-container">
        <div class="me-qr-header-box">
            <div class="me-qr-header">
                <?php esc_html_e('QR for pages settings', 'me-qr'); ?>
            </div>
        </div>

        <div class="me-qr-body-box">
            <div class="me-qr-settings-box me-qr-vertical-line-r">
                <?php $this->include('admin/pages/admin-settings/_premium', $params->all()); ?>
                <?php if ($user->isPermanentUser()) {
                    $this->include('admin/pages/admin-settings/_qr-code-management', $params->all());
                } ?>
                <?php $this->include('admin/pages/admin-settings/_shortcode-settings', $params->all()); ?>
                <?php $this->include('admin/pages/admin-settings/_logging-settings', $params->all()); ?>
                <?php if ($user->isPermanentUser()) {
                    $this->include('admin/pages/admin-settings/_sync-settings', $params->all());
                } ?>
            </div>

            <div class="me-qr-settings-box me-qr-account-box">
                <?php
                    if ($user->isPermanentUser()) {
                        $this->include('admin/pages/admin-settings/account/_login', $params->all());
                    } else {
                        $this->include('admin/pages/admin-settings/account/_no-login', $params->all());
                    }
                ?>
            </div>
        </div>

        <div class="me-qr-save-btn-box">
            <?php $this->include('modules/loading-module', ['id' => 'me_qr_js_save_settings_loading']); ?>
            <button type="button" class="me-qr-btn me-qr-save-btn me-qr-js-save-btn">
                <?php esc_html_e('Save Changes', 'me-qr'); ?>
            </button>
        </div>
    </div>

    <div id="me_qr_vars"
         data-nonce-key="<?php echo esc_attr($nonceKey) ?>"
         data-save-success-message="<?php esc_html_e('Settings saved successfully', 'me-qr'); ?>"
         data-save-error-message="<?php esc_html_e('Error saving settings: ', 'me-qr'); ?>"
         data-unknown-message="<?php esc_html_e('Unknown error', 'me-qr'); ?>"
    ></div>
    <?php

    $this->include('modules/notification-module');

    /* Js scripts */
    wp_enqueue_script(
        'me_qr_loading_module_script',
        PathService::buildJsUrl('modules/LoadingModule')
    );
    wp_enqueue_script(
        'me_qr_modal_window_script',
        PathService::buildJsUrl('modules/MeQrWindowModal'),
    );
    wp_set_script_translations('me_qr_modal_window_script', 'me-qr', ME_QR_LANG_PATH);
    wp_enqueue_script(
        'me_qr_admin_save_settings_script',
        PathService::buildJsUrl('admin/pages/admin-settings/SaveSettings')
    );
    wp_enqueue_script(
        'me_qr_admin_settings_page_script_index',
        PathService::buildJsUrl('admin/pages/admin-settings/index')
    );
};
