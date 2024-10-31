<?php

namespace Me_Qr\Services\Packages\Validator\Exceptions;

use Exception;

class ValidationException extends Exception implements ValidationExceptionInterface
{
    public function __construct(?string $message = null)
    {
        if (!$message) {
            $message = 'Data validation error';
        }

        parent::__construct($message);
    }
}
