<?php

namespace Me_Qr\Services\Auth\DTO;

use Me_Qr\Services\Packages\Validator\Assert\Constraints as MeQrAssert;

class MeQrUserAuthDTO
{
    /**
     * @MeQrAssert\NotBlank()
     * @MeQrAssert\Type(type="string")
     */
    private $authToken;

    /**
     * @MeQrAssert\NotBlank()
     * @MeQrAssert\Type(type="string")
     */
    private $qrToken;

    /**
     * @MeQrAssert\Type(type="string")
     */
    private $username;

    /**
     * @MeQrAssert\Type(type="bool")
     */
    private $premiumUserValue;

    public function __construct($authToken, $qrToken, $username, $premiumUserValue)
    {
        $this->authToken = $authToken;
        $this->qrToken = $qrToken;
        $this->username = $username;
        $this->premiumUserValue = $premiumUserValue;
    }

    public function getAuthToken(): string
    {
        return $this->authToken;
    }

    public function getQrToken(): string
    {
        return $this->qrToken;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getPremiumUserValue(): bool
    {
        return $this->premiumUserValue ?? false;
    }
}