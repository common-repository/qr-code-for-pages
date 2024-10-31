<?php

namespace Me_Qr\Services\Packages\Validator\Assert\Constraints;

class NotNull extends AbstractConstraint
{
    protected ?string $message = 'The property value is {{ prop }}, cannot be null';

    public function validate($value): bool
    {
        return $this->value !== null;
    }
}
