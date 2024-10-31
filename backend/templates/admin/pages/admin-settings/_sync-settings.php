<?php

use Me_Qr\Entity\BackupInfoEntity;
use Me_Qr\Services\File\PathService;
use Me_Qr\Services\Packages\Template\TemplateParams;

return function(TemplateParams $params): void
{
    /** @var BackupInfoEntity $backupInfo */
    $backupInfo = $params->getReq('backupInfo');

    $exportDate = $backupInfo->getExportDate() ?? esc_html__('never', 'me-qr');
    $importDate = $backupInfo->getImportDate() ?? esc_html__('never', 'me-qr');

    wp_enqueue_style(
        'me_qr_sync_settings_style', PathService::buildCssUrl('admin/pages/settings/sync-settings')
    );

    ?>
    <div class="me-qr-setting">
        <div class="me-qr-setting-header-box">
            <div class="me-qr-setting-header">
                <?php esc_html_e('Sync settings', 'me-qr'); ?>
            </div>
        </div>

        <div class="me-qr-setting-content">
            <div class="me-qr-setting-subheader-box">
                <div class="me-qr-setting-subheader">
                    <?php esc_html_e('Exporting settings', 'me-qr'); ?>
                </div>
            </div>

            <div class="me-qr-setting-desc">
                <p><?php esc_html_e(
                    'Allows you to save the current plugin settings on the Me-QR server for the possibility of ' .
                    'recovery in the future', 'me-qr'
                ); ?>.</p>
                <p><?php esc_html_e(
                    'This will allow you to quickly and easily restore settings in case of reinstalling or expanding ' .
                    'your account to other plugins in your projects', 'me-qr'
                ); ?>.</p>
                <p><?php esc_html_e(
                    'Before exporting, first save the changes to the current page', 'me-qr'
                ); ?>.</p>
            </div>
            <div class="me-qr-sync-container">
                <button type="button" class="me-qr-sync-btn me-qr-js-export-btn">
                    <?php esc_html_e('Export', 'me-qr'); ?>
                    <span class="me-qr-sync-details-box">
                        <span>
                            <?php esc_html_e('Last export', 'me-qr') ?>:
                        </span>
                        <span class="me-qr-export-date-box">
                            <?php esc_attr_e($exportDate) ?>
                        </span>
                    </span>
                </button>
                <?php $this->include('modules/loading-module', [
                    'id' => 'me_qr_export_loader',
                    'boxClass' => 'me-qr-export-loader-box',
                ]); ?>
            </div>

            <div class="me-qr-setting-subheader-box me-qr-mt-2">
                <div class="me-qr-setting-subheader">
                    <?php esc_html_e('Importing settings', 'me-qr'); ?>
                </div>
            </div>
            <div class="me-qr-setting-desc me-qr-mt-1">
                <p><?php esc_html_e('Import previously exported settings from the Me-QR server', 'me-qr'); ?>.</p>
            </div>
            <div class="me-qr-sync-container">
                <?php if (!$backupInfo->getExportDate()) {
                    $importBtnClass = 'me-qr-no-active-btn';
                } ?>
                <button type="button"
                    class="me-qr-sync-btn me-qr-js-import-btn <?php esc_html_e($importBtnClass ?? ''); ?>"
                >
                    <?php esc_html_e('Import', 'me-qr'); ?>
                    <span class="me-qr-sync-details-box">
                        <span>
                            <?php esc_html_e('Last import', 'me-qr') ?>:
                        </span>
                        <span class="me-qr-import-date-box">
                            <?php esc_attr_e($importDate) ?>
                        </span>
                    </span>
                </button>
                <?php $this->include('modules/loading-module', [
                    'id' => 'me_qr_import_loader',
                    'boxClass' => 'me-qr-import-loader-box',
                ]); ?>
            </div>
        </div>
    </div>
    <?php

    wp_enqueue_script(
        'me_qr_admin_sync_settings_script',
        PathService::buildJsUrl('admin/pages/admin-settings/SyncSettings')
    );
    wp_set_script_translations('me_qr_admin_sync_settings_script', 'me-qr', ME_QR_LANG_PATH );
};
