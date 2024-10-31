<?php

namespace Me_Qr\Services\AdminPages;

class AdminNotification
{
    public static function showInfo(string $message, bool $isAddCloseBtn = true): void
    {
        $prefix = ME_QR_PLUGIN_NAME . ' plugin info| ';
        self::showMessage($prefix, $message, 'notice-info', $isAddCloseBtn);
    }

    public static function showSuccess(string $message, bool $isAddCloseBtn = true): void
    {
        $prefix = ME_QR_PLUGIN_NAME . ' plugin success| ';
        self::showMessage($prefix, $message, 'notice-success', $isAddCloseBtn);
    }

    public static function showError(string $message, bool $isAddCloseBtn = true): void
    {
        $prefix = ME_QR_PLUGIN_NAME . ' plugin error| ';
        self::showMessage($prefix, $message, 'notice-error', $isAddCloseBtn);
    }

    public static function showWarning(string $message, bool $isAddCloseBtn = true): void
    {
        $prefix = ME_QR_PLUGIN_NAME . ' plugin error| ';
        self::showMessage($prefix, $message, 'notice-warning', $isAddCloseBtn);
    }

    private static function showMessage(string $prefix, string $message, string $type, bool $isAddCloseBtn = true): void
    {
        $noticeMessage = $prefix . $message;
        $closeBtnClass = $isAddCloseBtn ? 'is-dismissible' : '';
        $class = "$type $closeBtnClass";

        add_action('admin_notices', function() use ($noticeMessage, $class) {
            ?>
            <div class="notice <?php esc_attr_e($class); ?>">
                <p><?php esc_html_e($noticeMessage, 'me-qr'); ?></p>
            </div>
            <?php
        });
    }
}