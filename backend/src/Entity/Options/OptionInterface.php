<?php

namespace Me_Qr\Entity\Options;

interface OptionInterface
{
    /**
     * Indicates whether the option exists and whether it is distinguished from NULL
    */
    public static function isExist(): bool;

    /**
     * Gets the option
     *
     * @return mixed
    */
    public static function get();

    /**
     * Saves the value to the option
     * If the option is already there, then updates it
     *
     * @param mixed $value
     *
     * @return bool Returns true if saved or updated successfully
     */
    public static function save($value): bool;

    /**
     * Deletes the option
     *
     * @return bool Returns true if the option is successfully deleted
     */
    public static function delete(): bool;
}