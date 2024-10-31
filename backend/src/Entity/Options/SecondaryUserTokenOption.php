<?php

namespace Me_Qr\Entity\Options;

use Me_Qr\Entity\Keys\DBOptionsKeys;

class SecondaryUserTokenOption extends AbstractOption
{
    protected const OPTION_KEY = DBOptionsKeys::SECONDARY_USER_TOKEN_OPTION_KEY;

    public static function get(): ?string
    {
        $option = self::getOption();
        if (!is_string($option)) {
            return null;
        }

        return $option;
    }
}