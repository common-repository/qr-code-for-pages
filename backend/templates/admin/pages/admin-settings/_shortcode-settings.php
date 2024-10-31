<?php

use Me_Qr\Entity\PluginSettingsEntity;
use Me_Qr\Services\File\PathService;
use Me_Qr\Services\Packages\Template\TemplateParams;

return function(TemplateParams $params): void
{
    /** @var PluginSettingsEntity $pluginSettings */
    $pluginSettings = $params->getReq('pluginSettings');

    ?>
    <div class="me-qr-setting">
        <div class="me-qr-setting-header-box">
            <div class="me-qr-setting-header">
                <?php esc_html_e('Shortcode settings', 'me-qr'); ?>
            </div>
        </div>

        <div class="me-qr-setting-content">
            <div class="me-qr-setting-desc">
                <?php esc_html_e(
                    'Css class for the block containing the QR code, which is rendered by the shortcode',
                    'me-qr'
                ); ?>.
            </div>
            <div class="me-qr-setting-input-box">
                <label for="me_qr_sht_block_class_input">
                    <?php esc_html_e('Css QR-block class', 'me-qr'); ?>
                </label>
                <input type="text" id="me_qr_sht_block_class_input"
                       value="<?php echo esc_attr($pluginSettings->getQrBlockClass()) ?>"
                >
            </div>

            <div class="me-qr-setting-desc me-qr-mt-1">
                <?php esc_html_e(
                    'Css class for the QR code image that rendered by the shortcode',
                    'me-qr'
                ); ?>.
            </div>
            <div class="me-qr-setting-input-box">
                <label for="me_qr_sht_img_class_input">
                    <?php esc_html_e('Css QR-image class', 'me-qr'); ?>
                </label>
                <input type="text" id="me_qr_sht_img_class_input"
                       value="<?php echo esc_attr($pluginSettings->getQrImgClass()) ?>"
                >
            </div>
        </div>
    </div>
    <?php

    wp_enqueue_script(
        'me-qr_admin_shortcode_settings_script',
        PathService::buildJsUrl('admin/pages/admin-settings/ShortcodeSettings')
    );
};
