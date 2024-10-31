<?php

namespace Me_Qr\Services\Packages\Validator\Assert\Constraints;

class NotBlank extends AbstractConstraint
{
    protected ?string $message = 'The specified property value is {{ prop }}, cannot be null';

    public function validate($value): bool
    {
        return !($value === null || $value === '' || $value === []);
    }
}
