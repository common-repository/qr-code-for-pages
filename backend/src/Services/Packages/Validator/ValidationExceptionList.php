<?php

namespace Me_Qr\Services\Packages\Validator;

use Exception;
use Me_Qr\Services\Packages\Validator\Exceptions\ValidationExceptionInterface;

class ValidationExceptionList
{
    /**
     * @var Exception[]
     */
    private array $exceptions;

    /**
     * @param Exception[] $exceptions
     */
    public function __construct(
        array $exceptions = []
    ) {
        $this->exceptions = $exceptions;
    }

    /**
     * @return Exception[]
     */
    public function getExceptions(): array
    {
        return $this->exceptions;
    }

    public function getExceptionString(bool $isTranslate = false): string
    {
        $message = 'Validation errors';
        if ($isTranslate) {
            $message = __($message, 'me-qr');
        }

        $message .= ': ( ';
        $num = 1;
        foreach ($this->exceptions as $exception) {
            $exceptionMessage = $exception->getMessage();
            if ($isTranslate) {
                $exceptionMessage = __($exceptionMessage, 'me-qr');
            }

            $message .= " $num.$exceptionMessage;";
            $num++;
        }

        $message .= " )";

        return $message;
    }

    public function addException(ValidationExceptionInterface $exception): self
    {
        $this->exceptions[] = $exception;

        return $this;
    }

    public function isExceptions(): bool
    {
        return count($this->exceptions) > 0;
    }
}
