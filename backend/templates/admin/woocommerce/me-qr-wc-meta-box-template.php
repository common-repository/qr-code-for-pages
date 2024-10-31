<?php

use Me_Qr\Services\File\PathService;
use Me_Qr\Services\Packages\Template\TemplateParams;

return function(TemplateParams $params): void
{
    /* Css styles */
    wp_enqueue_style(
        'me_qr_loading_module_style', PathService::buildCssUrl('modules/loading-module')
    );
    wp_enqueue_style(
        'mq_wc_meta_box_style', PathService::buildCssUrl('admin/woocommerce/qr-meta-box')
    );

    $postId = $params->getReq('postId');
    $isQrExist = $params->get('isQrExist');
    $isUserPermanent = $params->get('isPermanentUser');

    ?>
    <div class="me-qr-wc-render-box">
        <div class="me-qr-desc-box">
            <div class="me-qr-desc">
                <?php if ($isQrExist) {
                    esc_html_e(
                        'The QR code has already been generated for this product. You can watch it.', 'me-qr'
                    );
                } else {
                    esc_html_e(
                        'Generate a QR-Code for the current product and use your online store to the fullest.', 'me-qr'
                    );
                } ?>
            </div>
        </div>

        <div class="me-qr-wc-render-btn-box">
            <button class="me-qr-btn me-qr-wc-render-btn" type="button">
                <?php if ($isQrExist) {
                    esc_html_e('Show QR-Code', 'me-qr');
                } else {
                    esc_html_e('Generate QR-Code', 'me-qr');
                } ?>
            </button>
        </div>
    </div>

    <?php $this->include('modules/loading-module', [
        'message' => esc_html__('QR code is loading, please wait...', 'me-qr')
    ]); ?>

    <div class="me-qr-wc-body me-qr-d-none">
        <div class="me-qr-wc-img-box">
            <img src="" class="me-qr-wc-img" alt="qr_code_img"/>
        </div>

        <div class="me-qr-wc-choice-box">
            <div class="me-qr-wc-choice-item">
                <input type="radio" id="me_qr_svg_radio" name="me_qr_wc_choice_qr_format" value="svg"/>
                <label for="me_qr_svg_radio">svg</label>
            </div>

            <div class="me-qr-wc-choice-item">
                <input type="radio" id="me_qr_wc_png_radio" name="me_qr_wc_choice_qr_format" value="png" checked />
                <label for="me_qr_wc_png_radio">png</label>
            </div>
        </div>

        <div class="me-qr-wc-btn-box">
            <a href="" download="qr_code" class="me-qr-btn me-qr-wc-download-btn">
                <?php esc_html_e('Download QR Code', 'me-qr'); ?>
            </a>
        </div>

        <div class="me-qr-wc-shortcode-box">
            <input type="text" class="me-qr-wc-shortcode-input" value="" />
            <div class="me-qr-wc-shortcode-copy-btn-box">
                <div class="me-qr-wc-shortcode-copy-btn"
                     data-default-text="<?php esc_html_e('Copy shortcode', 'me-qr'); ?>"
                     data-success-text="<?php esc_html_e('Copied', 'me-qr'); ?>"
                     data-failed-text="<?php esc_html_e('Not copied', 'me-qr'); ?>"
                >
                    <?php esc_html_e('Copy shortcode', 'me-qr'); ?>
                </div>
            </div>
        </div>

        <?php if ($isUserPermanent) { ?>
            <div class="me-qr-wc-reload-btn me-qr-wc-js-reload-btn"
                 title="<?php esc_html_e('Update QR Code', 'me-qr'); ?>"
            >
                ↻
            </div>
        <?php } ?>
    </div>

    <div class="me-qr-error-box me-qr-d-none">
        <div class="error-header">
            <?php esc_html_e('QR code was not generated.', 'me-qr'); ?>
        </div>
        <div class="error-desc">
            <?php esc_html_e('Try reloading the page or reinstalling the plugin', 'me-qr'); ?>
        </div>
    </div>
    <?php

    /* Js scripts */
    wp_enqueue_script(
        'me_qr_loading_module_script',
        PathService::buildJsUrl('modules/LoadingModule')
    );
    wp_enqueue_script(
        'mq_wc_error_module_script',
        PathService::buildJsUrl('modules/ErrorModule')
    );
    wp_enqueue_script(
        'mq_wc_shortcode_input_script',
        PathService::buildJsUrl('admin/woocommerce/meta-box/MeQrShortcodeInput')
    );
    wp_enqueue_script(
        'mq_wc_meta_box_script', PathService::buildJsUrl('admin/woocommerce/meta-box/MeQrMetaBox')
    );
    wp_enqueue_script(
        'mq_wc_meta_box_index_script', PathService::buildJsUrl('admin/woocommerce/index')
    );
    wp_add_inline_script('mq_wc_meta_box_index_script', "let postId = $postId;", 'before');
};
