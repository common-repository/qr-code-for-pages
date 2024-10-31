<?php

namespace Me_Qr\Services\Packages\Validator\Assert\Constraints;

class DateTime extends AbstractConstraint
{
    public const VALID_FORMAT_PROPERTY = 'format';

    public const FORMAT_PLACEHOLDER = '{{ format }}';

    /*
     * Date Time data validation format
    */
    private string $format = 'Y-m-d H:i:s';

    protected ?string $message = "The value of {{ value }} does not match the format `{{ format }}`"
    ;

    public function declareOptions(array $options): void
    {
        $format = $options[self::VALID_FORMAT_PROPERTY] ?? null;
        if ($format) {
            $this->format = $format;
        }
    }

    public function validate($value): bool
    {
        if ($value === null) {
            return true;
        }
        if (!is_string($value) || $value === '') {
            return false;
        }


        return \DateTime::createFromFormat($this->format, $value) !== false;
    }

    public function fillMessage(): void
    {
        $this->message = str_replace(self::FORMAT_PLACEHOLDER, $this->format, $this->message);
    }
}
