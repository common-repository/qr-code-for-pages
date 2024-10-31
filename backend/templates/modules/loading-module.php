<?php

use Me_Qr\Services\Packages\Template\TemplateParams;

return static function(TemplateParams $params): void
{
    $id = $params->get('id');
    $boxClass = $params->get('boxClass');
    $loaderClass = $params->get('loaderClass');
    $message = $params->get('message');

    ?>
    <div class="me-qr-loading-module me-qr-d-none <?php echo esc_attr($boxClass) ?>"
         id="<?php echo esc_attr($id) ?>"
    >
        <div class="me-qr-loader <?php echo esc_attr($loaderClass) ?>"></div>

        <?php if ($message) { ?>
            <div class="me-qr-loader-text-box">
                <div class="me-qr-loader-text">
                    <?php echo esc_html($message); ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php
};
