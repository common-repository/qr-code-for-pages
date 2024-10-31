<?php

namespace Me_Qr\Entity;

use JsonSerializable;

class MeQrUserEntity implements JsonSerializable, EntityInterface
{
    public const AUTH_TOKEN_KEY = 'authToken';
    public const QR_TOKEN_KEY = 'qrToken';
    public const USERNAME_KEY = 'username';
    public const IS_PERMANENT_USER_KEY = 'permanent';
    public const IS_PREMIUM_KEY = 'premium';

    private string $authToken;

    private string $qrToken;

    private ?string $username;

    private bool $isPermanentUser = false;

    private bool $isUserPremium = false;

    public function getAuthToken(): string
    {
        return $this->authToken;
    }

    public function setAuthToken(string $authToken): self
    {
        $this->authToken = $authToken;

        return $this;
    }

    public function getQrToken(): string
    {
        return $this->qrToken;
    }

    public function setQrToken(string $qrToken): self
    {
        $this->qrToken = $qrToken;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function isPermanentUser(): bool
    {
        return $this->isPermanentUser;
    }

    public function setIsPermanentUser(bool $isPermanentUser): self
    {
        $this->isPermanentUser = $isPermanentUser;

        return $this;
    }

    public function isUserPremium(): bool
    {
        return $this->isUserPremium;
    }

    public function setIsUserPremium(bool $isUserPremium): self
    {
        $this->isUserPremium = $isUserPremium;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            self::AUTH_TOKEN_KEY => $this->authToken,
            self::QR_TOKEN_KEY => $this->qrToken,
            self::USERNAME_KEY => $this->username,
            self::IS_PERMANENT_USER_KEY => $this->isPermanentUser,
            self::IS_PREMIUM_KEY => $this->isUserPremium,
        ];
    }
}