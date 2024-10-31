<?php

namespace Me_Qr\Entity\Options;

use Me_Qr\Entity\Keys\DBOptionsKeys;

class PluginSettingsOption extends AbstractOption
{
    protected const OPTION_KEY = DBOptionsKeys::PLUGIN_SETTINGS_OPTION;

    public static function get(): ?array
    {
        $option = self::getOption();
        if (!is_array($option)) {
            return null;
        }

        return $option;
    }

    /**
     * @param array $value
     */
    public static function save($value): bool
    {
        if (!is_array($value)) {
            return false;
        }

        return self::saveOption($value);
    }
}