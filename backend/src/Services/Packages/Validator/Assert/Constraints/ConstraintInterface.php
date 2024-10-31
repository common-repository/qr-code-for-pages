<?php

namespace Me_Qr\Services\Packages\Validator\Assert\Constraints;

use Me_Qr\Services\Packages\Validator\Exceptions\ValidationExceptionInterface;

interface ConstraintInterface
{
    /**
     * Sets the name of the current validation type
     */
    public static function getTitle();

    /**
     * Here you can get all the options passed in the annotation parameters
     *
     * @throws ValidationExceptionInterface You can throw exceptions if the required parameters are missing
     */
    public function declareOptions(array $options): void;

    /**
     * The main method for validating a value.
     * Should return true on successful validation, false on failure.
     */
    public function validate($value): bool;
}
