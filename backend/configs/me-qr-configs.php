<?php

// Indicates the type of environment (dev or prod)
// Only needed for development.
// Don't change the value on dev while in production!
define('ME_QR_APP_ENV', 'prod');

// Display name of the plugin in logs, error messages and other places
define('ME_QR_PLUGIN_NAME', 'QR Code for Pages');

// <----- API configs
// This is the maximum wait time for a server response before a server unreachable exception is thrown.
// Value in seconds.
define('ME_QR_REQUEST_TIMEOUT', 10);
// END API configs ----->

// <----- Logs configs
// Option to allow logging to the file log of plugin errors.
// Does not take precedence over the value in the options table.
define('ME_QR_IS_WRITING_PLUGIN_LOGS_DEFAULT', true);

// Option to allow logging in telegram plugin error log.
// Does not take precedence over the value in the options table.
define('ME_QR_IS_SENDING_TG_LOGS_DEFAULT', true);
// END Logs configs ----->
