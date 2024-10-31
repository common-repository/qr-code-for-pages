<?php

namespace Me_Qr\Services\Packages\Validator\Assert\Models;

class ValidatedClass
{
    private bool $translate = false;

    public function isTranslate(): bool
    {
        return $this->translate;
    }

    public function setTranslate(bool $translate): self
    {
        $this->translate = $translate;

        return $this;
    }
}