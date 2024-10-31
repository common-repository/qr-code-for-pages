<?php

namespace Me_Qr\Services\Packages\Validator\Assert\Constraints;

use Me_Qr\Services\Packages\Validator\Exceptions\ValidationExceptionInterface;
use Me_Qr\Services\Packages\Validator\Exceptions\ValidationSystemError;

class Type extends AbstractConstraint
{
    public const VALID_TYPE_PROPERTY = 'type';
    public const VALID_TYPE_PLACEHOLDER = '{{ type }}';
    public const INVALID_TYPE_PLACEHOLDER = '{{ invalid }}';

    /**
     * Expected value type (int, integer, numeric, double, string, bool, boolean, array, object)
     */
    private string $type;

    protected ?string $message = "The value `{{ value }}` should be of type {{ type }}, {{ invalid }} given";

    /**
     * @throws ValidationExceptionInterface
     */
    public function declareOptions(array $options): void
    {
        $validType = $options[self::VALID_TYPE_PROPERTY] ?? null;
        if (!$validType || !is_string($validType)) {
            throw new ValidationSystemError('Valid format required property error');
        }
        if ($validType === 'int') {
            $validType = 'integer';
        }
        if ($validType === 'bool') {
            $validType = 'boolean';
        }

        $this->type = $validType;
    }

    public function validate($value): bool
    {
        if ($value === null) {
            return true;
        }
        if ($this->type === 'numeric') {
            return is_numeric($value);
        }

        return gettype($value) === $this->type;
    }

    public function fillMessage(): void
    {
        $this->message = str_replace(
            [
                self::VALID_TYPE_PLACEHOLDER,
                self::INVALID_TYPE_PLACEHOLDER,
            ],
            [
                $this->type,
                gettype($this->value),
            ],
            $this->message
        );
    }
}