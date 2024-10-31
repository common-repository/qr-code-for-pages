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
                <?php esc_html_e('Logging settings', 'me-qr'); ?>
            </div>
        </div>

        <div class="me-qr-setting-content">
            <div class="me-qr-setting-desc">
                <p><?php esc_html_e(
                    'Write critical plugin errors to the general project log-file for quick debugging', 'me-qr'
                ); ?>.</p>
            </div>
            <div class="me-qr-setting-input-box">
                <label for="me_qr_file_logging_value_checkbox" class="me-qr-input-label">
                    <?php esc_html_e('File logging', 'me-qr'); ?>
                </label>
                <div class="me-qr-checkbox-container">
                    <input type="checkbox" id="me_qr_file_logging_value_checkbox"
                        <?php if ($pluginSettings->isFileLogging()) { esc_html_e('checked'); } ?>
                    >
                </div>
            </div>


            <div class="me-qr-setting-desc me-qr-mt-1">
                <p><?php esc_html_e(
                    'Send a bug report to the plugin developer', 'me-qr'
                ); ?>.</p>
            </div>
            <div class="me-qr-setting-input-box">
                <label for="me_qr_tg_logging_value_checkbox" class="me-qr-input-label">
                    <?php esc_html_e('Send a report', 'me-qr'); ?>
                </label>
                <div class="me-qr-checkbox-container">
                    <input type="checkbox" id="me_qr_tg_logging_value_checkbox"
                        <?php if ($pluginSettings->isTgLogging()) { esc_html_e('checked'); } ?>
                    >
                </div>
            </div>
        </div>
    </div>
    <?php

    wp_enqueue_script(
        'me-qr_admin_logging_settings_script',
        PathService::buildJsUrl('admin/pages/admin-settings/LoggingSettings')
    );
};
