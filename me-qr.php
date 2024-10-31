<?php

/*
Plugin Name: QR Code for Pages
Description: Is a plugin for generating QR codes for your WordPress pages or posts made by ME-Team.
Version: 2.2
Requires at least: 5.8
Requires PHP: 7.4
Author: Me-Team
Author URI: https://me-team.org/
License: GPLv2 or later
Text Domain: me-qr
Domain Path: /languages
*/

defined('ABSPATH' ) || exit;

use Me_Qr\Core\Container;
use Me_Qr\Core\MeQrPluginExecute;
use Me_Qr\Services\Loggers\PluginCriticalErrorLogger;

/* Base plugin constants */
define( 'ME_QR_FILE_PATH', __FILE__ );
define( 'ME_QR_TEXT_DOMAIN', 'me-qr' );
define( 'ME_QR_APP_PATH', trailingslashit( plugin_dir_path( ME_QR_FILE_PATH ) ) );
define( 'ME_QR_APP_URL', trailingslashit( plugins_url( '/', ME_QR_FILE_PATH ) ) );
define( 'ME_QR_LANG_PATH', ME_QR_APP_PATH . 'languages' );

try {
    /* Composer autoload */
    require_once __DIR__ . '/backend/vendor/autoload.php';
    require_once __DIR__ . '/backend/configs/me-qr-configs.php';
    require_once __DIR__ . '/backend/configs/' . ME_QR_APP_ENV . '/me-qr-sys-configs.php';

    ( ( new Container() )->get(MeQrPluginExecute::class) )->execute();
} catch (Throwable $e) {
    PluginCriticalErrorLogger::logCoreException($e);
}
