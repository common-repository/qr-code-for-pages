<?php

namespace Me_Qr\Services\Packages\Validator\Assert\Constraints;

use Me_Qr\Services\Packages\Validator\Assert\Models\ValidatedClass;
use Me_Qr\Services\Packages\Validator\Exceptions\ValidationException;
use Me_Qr\Services\Packages\Validator\Exceptions\ValidationExceptionInterface;

abstract class AbstractConstraint implements ConstraintInterface
{
    public const ERROR_MESSAGE_PROPERTY = 'message';
    public const IS_TRANSLATE_PROPERTY = 'translate';

    protected const VALUE_PLACEHOLDER = '{{ value }}';
    protected const PROPERTY_PLACEHOLDER = '{{ prop }}';

    /**
     * @var mixed
     */
    protected $value;

    protected string $property;

    protected array $options;

    /**
     * Determines whether the message needs to be translated
     * Takes precedence over the global class option
     */
    protected ?bool $translate = null;

    protected ?string $message = 'The specified value {{ value }} of the property {{ prop }}, is not valid';

    private ValidatedClass $validatedClass;

    public static function getTitle(): string
    {
        $classParts = explode('\\', static::class);
        return array_pop($classParts);
    }

    /**
     * @param mixed $value
     * @throws ValidationExceptionInterface
     */
    public function handel(
        ValidatedClass $validatedClass,
        string $property,
        $value,
        array $options
    ): ?ValidationException {
        $this->declareSystemOptions($validatedClass, $property, $value, $options);
        $this->declareOptions($options);
        $this->translateMessage();
        $this->fillSystemMessage();
        $this->fillMessage();

        $result = $this->validate($value);
        if (!$result) {
            return new ValidationException($this->message);
        }

        return null;
    }

    private function declareSystemOptions(
        ValidatedClass $validatedClass,
        string $property,
        $value,
        array $options
    ): void {
        $this->validatedClass = $validatedClass;
        $this->value = esc_html__($value);
        $this->property = $property;
        $this->options = $options;

        $errorMessage = $options[self::ERROR_MESSAGE_PROPERTY] ?? null;
        if ($errorMessage && is_string($errorMessage)) {
            $this->message = $errorMessage;
        }
        $translate = $options[self::IS_TRANSLATE_PROPERTY] ?? null;
        if ($translate === 'true') {
            $this->translate = true;
        }
        if ($translate === 'false') {
            $this->translate = false;
        }
    }

    /**
     * @throws ValidationExceptionInterface
     */
    public function declareOptions(array $options): void
    {
        // Here you can add your own options for validation
    }

    protected function translateMessage(): void
    {
        if ($this->translate || ($this->translate === null && $this->validatedClass->isTranslate())) {
            $this->message = esc_html__($this->message, 'me-qr');
        }
    }

    protected function fillSystemMessage(): void
    {
        $value = $this->value;
        if (!in_array(gettype($value), ['string', 'integer', 'bool', 'double', 'NULL'], true)) {
            $value = gettype($value);
        }
        if (mb_strlen($value) > 100) {
            $value = mb_substr($value, 0, 50) . '...';
        }

        $this->message = str_replace(
            [
                self::VALUE_PLACEHOLDER,
                self::PROPERTY_PLACEHOLDER,
            ],
            [
                $value,
                $this->property,
            ],
            $this->message
        );
    }

    public function fillMessage(): void
    {
        // Here you can add placeholders to the error message
    }
}
