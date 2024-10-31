<?php

namespace Me_Qr\Services\Redirect;

use Me_Qr\Services\Auth\AuthDataOptions;
use Me_Qr\Services\Auth\AuthTokenService;

class MeQrRedirectService
{
    public const QUERY_DATA_KEY = 'data';
    public const TARGET_BACK_KEY = 'redirectUri';
    public const LOCALE_KEY = 'locale';

    private function createMeQrAuthUri(string $path, ?string $targetBackUrl = null): string
    {
        $queryData = [
	        AuthDataOptions::AUTH_TOKEN_KEY => AuthTokenService::getSecondaryToken(),
	        self::TARGET_BACK_KEY => $targetBackUrl,
	        self::LOCALE_KEY => $this->getValidLocale(),
        ];
        $encodeQueryData = base64_encode(json_encode($queryData));

        return ME_QR_URL . "$path?" . self::QUERY_DATA_KEY . "=$encodeQueryData";
    }

    private function createMeQrRedirectUriByPath(string $path): string
    {
        return ME_QR_URL . "{$this->getValidLocale()}/$path";
    }

    private function getValidLocale(): string
    {
        $locale = get_locale();
        $parts = explode('_', $locale);
        if (count($parts) > 0) {
            return strtolower($parts[0]);
        }

        return strtolower($locale);
    }

    public function getLoginPageLink(): string
    {
        return $this->createMeQrAuthUri(ME_QR_LOGIN_PATH);
    }

    public function getRegistrationPageLink(): string
    {
        return $this->createMeQrAuthUri(ME_QR_REGISTRATION_PATH);
    }

    public function getPricingPageLink(): string
    {
        return $this->createMeQrRedirectUriByPath(ME_QR_PRICING_PAGE_PATH);
    }

    public function getPremiumPageLink(): string
    {
        return $this->createMeQrRedirectUriByPath(ME_QR_ADMIN_PREMIUM_PAGE_PATH);
    }

    public function getQrPageLink(): string
    {
        return $this->createMeQrRedirectUriByPath(ME_QR_ADMIN_QR_PATH);
    }
}