<?php

namespace Me_Qr\Entity\Keys;

interface DBOptionsKeys
{
	// This is the name of the user token parameter, which is written to the _options table in case of successful user
	// registration on our server
	public const USER_OPTION_KEY = 'me_qr_user';

	// The option key of the secondary user token required to restore the mandatory user after logging out of
	// the plugin account
	public const SECONDARY_USER_TOKEN_OPTION_KEY = 'me_qr_secondary_user_token';

	// The option key to determine generated qr codes
	public const QR_CODES_OPTION_KEY = 'me_qr_qr_codes';

	// Parameter containing plugin settings
	public const PLUGIN_SETTINGS_OPTION = 'me_qr_plugin_settings';

	// An option that contains information on the data of the plugin settings backup
	public const PLUGIN_SETTINGS_BACKUP_INFO_OPTION_KEY = 'me_qr_plugin_backup_info';

	// This is the name of the _options table parameter for storing non-unique exception locations in the plugin
	// Needed to filter the sending of duplicate logs
	public const UNIQUE_EXCEPTIONS_OPTION = 'me_qr_unique_exceptions';
}