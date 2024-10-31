<?php

namespace Me_Qr\Services\Packages\Validator\Exceptions;

use Exception;

class ValidationSystemError extends Exception implements ValidationExceptionInterface
{
    public function __construct(?string $message = null)
    {
        $messagePrefix = 'Validation system error. Validation failed';
        if ($message) {
            $finalMessage = sprintf(esc_html__("$messagePrefix. Error message: `%s`", 'me-qr'), $message);
        } else {
            $finalMessage = esc_html__($messagePrefix, 'me-qr');
        }

        parent::__construct($finalMessage);
    }
}
