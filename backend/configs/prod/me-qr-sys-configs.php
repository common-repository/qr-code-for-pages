<?php
// <----- API configs
define('ME_QR_URL', 'https://me-qr.com/');

// Url for admin registration on our server.
// This allows you to identify the application and restore qr codes if the plugin is deleted.
define('ME_QR_REGISTRATION_SECONDARY_USER_URL', ME_QR_URL . 'api/wordpress/create/secondary-user');

// Url to get a qr-code of one format
define('ME_QR_GET_QR_REQUEST_URL', ME_QR_URL . 'api/wordpress/create/qr');

// Url to get qr-code in several formats
define('ME_QR_GET_ALL_QR_REQUEST_URL', ME_QR_URL . 'api/wordpress/create/all-qr');

// Url to export plugin settings
define('ME_QR_EXPORT_SETTINGS_REQUEST_URL', ME_QR_URL . 'api/wordpress/plugin-settings/export');

// Url to import plugin settings
define('ME_QR_IMPORT_SETTINGS_REQUEST_URL', ME_QR_URL . 'api/wordpress/plugin-settings/import');
// END API configs ----->


// <----- Me-qr uri paths
// Redirect URL for user authorization from the plugin to Me-QR
define('ME_QR_LOGIN_PATH', 'wordpress/qr-plugin/account/login');

// Redirect URL for user registration from the plugin on Me-QR
define('ME_QR_REGISTRATION_PATH', 'wordpress/qr-plugin/account/register');

// Redirect URL of the qr codes page
define('ME_QR_ADMIN_QR_PATH', 'entry/');

// Redirect URL of the pricing page
define('ME_QR_PRICING_PAGE_PATH', 'pricing');

// Redirect URL of the premium page
define('ME_QR_ADMIN_PREMIUM_PAGE_PATH', 'subscription/admin');
// END Me-qr uri pages ----->


// <----- File configs
// Title of me-qr plugin content in upload directory
define('ME_QR_CONTENT_DIR_TITLE', '/me-qr-data');

// Title of qr codes download directory
define('ME_QR_CODE_DOWNLOAD_DIR_TITLE', ME_QR_CONTENT_DIR_TITLE . '/qr-codes');

// Specifies the path where all css files are located in the plugin's file system
define('ME_QR_CSS_PATH', 'backend/assets/css/');

// Specifies the path where all js files are located in the plugin's file system
define('ME_QR_JS_PATH', 'backend/assets/js/');

// Specifies the path where all template files are located in the plugin's file system
define('ME_QR_TEMPLATE_PATH', 'backend/templates/');
// <----- END Logging configs


// <----- TGLog configs
// Bot Data
define('ME_QR_TELEGRAM_BOT_TOKEN', 'NTg1OTU5ODMyMTpBQUVSaExMdkxQTEZhZklXOEFNQ1VqSjRDQ2ZTbzd3aGhLdw==');
define('ME_QR_TELEGRAM_CHAT_ID', 'LTEwMDE4MTA2MDE0NDQ=');
// END TGLog configs ----->


// <----- Logging configs
// Code for finding errors related to the plugin in the log file of the WordPress project
define('ME_QR_ERROR_LOG_PREFIX', 'MQP|' . ME_QR_PLUGIN_NAME);

// Specifies whether to write exceptions to the file log.
// This parameter takes precedence over other logging file parameters.
// If set to "null" - not used
// If set to "true" - logs are always kept
// If set to false - no logs are always kept
define('ME_QR_ENABLE_FILE_LOG_PARAM', null);

// Specifies whether to write exceptions to the telegram log.
// This parameter takes precedence over other logging telegram parameters.
// If set to "null" - not used
// If set to "true" - logs are always kept
// If set to false - no logs are always kept
define('ME_QR_ENABLE_TG_LOG_PARAM', null);
// <----- END Logging configs


// <----- Other configs
// Sets allowed formats for qr code
define('ME_QR_PNG_FORMAT', 'png');
define('ME_QR_SVG_FORMAT', 'svg');
define('ME_QR_VALID_QR_FORMATS', [ME_QR_PNG_FORMAT, ME_QR_SVG_FORMAT]);
// END Other configs ----->
