<?php

namespace Me_Qr\Services\Auth;

interface AuthDataOptions
{
    public const AUTH_TOKEN_OF_SECONDARY_USER_KEY = 'authTokenOfSecondaryUser';
    public const AUTH_TOKEN_KEY = 'authToken';
    public const QR_TOKEN_KEY = 'qrToken';
    public const USERNAME_KEY = 'username';
    public const IS_PREMIUM_KEY = 'isPremiumUser';
}