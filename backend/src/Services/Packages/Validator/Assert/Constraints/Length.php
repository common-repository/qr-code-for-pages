<?php

namespace Me_Qr\Services\Packages\Validator\Assert\Constraints;

use Me_Qr\Services\Packages\Validator\Exceptions\ValidationExceptionInterface;
use Me_Qr\Services\Packages\Validator\Exceptions\ValidationSystemError;

/**
 * Validates a string value by the number of valid characters
 */
class Length extends AbstractConstraint
{
    public const MIN_PROPERTY = 'min';
    public const MAX_PROPERTY = 'max';

    public const MIN_PLACEHOLDER = '{{ min }}';
    public const MAX_PLACEHOLDER = '{{ max }}';

    /**
     * A numeric type value containing the minimum allowable value of the characters of the validated value
     */
    private int $min = 0;

    /**
     * A numeric type value containing the maximum allowable value of the characters of the validated value
     */
    private int $max = 255;

    protected ?string $message =
        "The value {{ value }} can contain a minimum of {{ min }} and a maximum of {{ max }} characters"
    ;

    /**
     * @throws ValidationExceptionInterface
     */
    public function declareOptions(array $options): void
    {
        $minVal = $options[self::MIN_PROPERTY] ?? null;
        if ($minVal && !is_numeric($minVal)) {
            throw new ValidationSystemError('Specify a valid parameter of the minimum valid value');
        }
        $maxVal = $options[self::MAX_PROPERTY] ?? null;
        if ($maxVal && !is_numeric($maxVal)) {
            throw new ValidationSystemError('Specify the valid parameter of the maximum valid value');
        }

        if ($minVal) {
            $this->min = $minVal;
        }
        if ($maxVal) {
            $this->max = $maxVal;
        }
    }

    public function validate($value): bool
    {
        if (!is_string($value)) {
            return true;
        }

        $length = mb_strlen($value);
        if ($length < $this->min || $length > $this->max) {
            return false;
        }

        return true;
    }

    public function fillMessage(): void
    {
        $this->message = str_replace(
            [
                self::MIN_PLACEHOLDER,
                self::MAX_PLACEHOLDER,
            ],
            [
                $this->min,
                $this->max,
            ],
            $this->message
        );
    }
}