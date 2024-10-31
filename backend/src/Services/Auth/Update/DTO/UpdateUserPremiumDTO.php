<?php

namespace Me_Qr\Services\Auth\Update\DTO;

class UpdateUserPremiumDTO
{
    /**
     * @MeQrAssert\Type(type="bool")
     */
    private $premiumUserValue;

    public function __construct($premiumUserValue)
    {
        $this->premiumUserValue = $premiumUserValue;
    }

    public function getPremiumUserValue(): bool
    {
        return $this->premiumUserValue;
    }
}