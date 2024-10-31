<?php

defined('ABSPATH' ) || exit;
defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

use Me_Qr\Core\Container;
use Me_Qr\Core\MeQrPluginUninstallExecute;
use Me_Qr\Services\Loggers\PluginCriticalErrorLogger;

require_once __DIR__ . '/backend/vendor/autoload.php';
require_once __DIR__ . '/backend/configs/me-qr-configs.php';
require_once __DIR__ . '/backend/configs/' . ME_QR_APP_ENV . '/me-qr-sys-configs.php';

try {
    ( (new Container())->get(MeQrPluginUninstallExecute::class) )->execute();
} catch (Throwable $e) {
    PluginCriticalErrorLogger::logUninstallPluginException($e);
}
