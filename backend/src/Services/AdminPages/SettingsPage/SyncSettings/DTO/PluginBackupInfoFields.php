<?php

namespace Me_Qr\Services\AdminPages\SettingsPage\SyncSettings\DTO;

interface PluginBackupInfoFields
{
    public const REQUEST_BACKUPS_KEY = 'pluginBackups';
    public const USER_ID_KEY = 'wpUserId';
    public const SITE_URL_KEY = 'siteUrl';
    public const BACKUP_DATE_TIME_KEY = 'backupDatetime';
}