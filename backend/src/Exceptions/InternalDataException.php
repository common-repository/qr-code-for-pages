<?php

namespace Me_Qr\Exceptions;

use Exception;

class InternalDataException extends Exception
{
    private array $context;

    public function __construct(string $message = 'Unknown internal data error', array $context = []) {

        parent::__construct($message);

        $this->context = $context;
    }

    public function getContext(): array
    {
        return $this->context;
    }
}