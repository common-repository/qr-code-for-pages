<?php

namespace Me_Qr\Entity\Options;

abstract class AbstractOption implements OptionInterface
{
    protected const OPTION_KEY = 'abstract-option';
    protected const IS_TRANSIENT = false;

    public static function isExist(): bool
    {
        return self::isExistOption();
    }

    public static function save($value): bool
    {
        return self::saveOption($value);
    }

    public static function delete(): bool
    {
        return self::deleteOptionByConfig();
    }

    /**
     * @return mixed
     */
    private static function getOptionByConfig()
    {
        if (static::IS_TRANSIENT) {
            return get_transient(static::OPTION_KEY);
        }

        return get_option(static::OPTION_KEY);
    }

    /**
     * @param $value mixed
     */
    private static function addOptionByConfig($value): bool
    {
        if (static::IS_TRANSIENT) {
            return set_transient(static::OPTION_KEY, $value);
        }

        return add_option(static::OPTION_KEY, $value);
    }

    /**
     * @param $value mixed
     */
    private static function updateOptionByConfig($value): bool
    {
        if (static::IS_TRANSIENT) {
            return set_transient(static::OPTION_KEY, $value);
        }

        return update_option(static::OPTION_KEY, $value);
    }

    private static function deleteOptionByConfig(): bool
    {
        if (static::IS_TRANSIENT) {
            return delete_transient(static::OPTION_KEY);
        }

        return delete_option(static::OPTION_KEY);
    }

    protected static function isExistOption(
        bool $checkEmptyString = true,
        bool $checkEmptyArray = true
    ): bool {
        $option = self::getOptionByConfig();
        if ($option === false || $option === null) {
            return false;
        }
        if ($checkEmptyString && $option === '') {
            return false;
        }
        if ($checkEmptyArray && is_array($option) && empty($option)) {
            return false;
        }

        return true;
    }

    /**
     * @return mixed|null
     */
    protected static function getOption(
        bool $checkEmptyString = true,
        bool $checkEmptyArray = true
    ) {
        $optionValue = self::getOptionByConfig();
        if (!self::isExistOption($checkEmptyString, $checkEmptyArray)) {
            return null;
        }
        if (is_bool($optionValue)) {
            $optionValue = var_export($optionValue, true);
        }

        return $optionValue;
    }

    protected static function saveOption($value): bool
    {
        if (is_bool($value)) {
            $value = var_export($value, true);
        }

        $optionValue = self::getOptionByConfig();
        if ($optionValue === $value) {
            return true;
        }

        if ($optionValue) {
            return self::updateOptionByConfig($value);
        }

        return self::addOptionByConfig($value);
    }
}