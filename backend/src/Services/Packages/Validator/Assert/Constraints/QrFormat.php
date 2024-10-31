<?php

namespace Me_Qr\Services\Packages\Validator\Assert\Constraints;

class QrFormat extends AbstractConstraint
{
    protected ?string $message = 'The QR code format does not match the available formats';

    public function validate($value): bool
    {
        if (!$this->value) {
            return false;
        }

        $isValidFormats = in_array($value, ME_QR_VALID_QR_FORMATS, true);
        if (!$isValidFormats) {
            return false;
        }

        return true;
    }
}
