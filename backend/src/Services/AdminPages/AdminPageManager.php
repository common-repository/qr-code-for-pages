<?php

namespace Me_Qr\Services\AdminPages;

use Me_Qr\Services\AdminPages\SettingsPage\SettingsPageHandler;

class AdminPageManager
{
    private SettingsPageHandler $settingsPageHandler;

    public function __construct(SettingsPageHandler $settingsPageHandler)
    {
        $this->settingsPageHandler = $settingsPageHandler;
    }

    public function registerAll(): void
    {
        add_action('admin_menu', function() {
            $this->settingsPageHandler->registerPage();
        });
    }
}