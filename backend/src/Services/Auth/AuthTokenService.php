<?php

namespace Me_Qr\Services\Auth;

use Me_Qr\Entity\MeQrUserEntity;
use Me_Qr\Entity\Options\SecondaryUserTokenOption;
use Me_Qr\Exceptions\InternalDataException;
use Me_Qr\Repository\MeQrUserRepository;
use Throwable;
use WP_REST_Request;

class AuthTokenService
{
	public static function getAuthToken(): ?string
	{
		try {
			return self::getReqAuthToken();
		} catch ( Throwable $e) {
			return null;
		}
	}

	/**
	 * @throws InternalDataException
	 */
	public static function getReqAuthToken(): string
	{
		$user = MeQrUserRepository::findEntity();
		if (!$user) {
			throw new InternalDataException('Me qr user not found in database');
		}

		return $user->getAuthToken();
	}

    public static function checkAuthToken(string $authToken): bool
    {
        return self::getAuthToken() === $authToken;
    }

	/**
	 * @throws InternalDataException
	 */
	public static function checkAuthTokenByRequest(WP_REST_Request $request): void
	{
		$authToken = $request->get_param(AuthDataOptions::AUTH_TOKEN_KEY);
		if (!is_string($authToken)) {
			throw new InternalDataException('Auth token is not a valid type. Expected string', [
				'givenType' => gettype($authToken),
			]);
		}

		if (!self::checkAuthToken($authToken)) {
			throw new InternalDataException( 'Auth token is not valid', ['invalidToken' => $authToken]);
		}
	}

	/**
	 * @throws InternalDataException
	 */
	public static function checkSecondaryAuthTokenByRequest(WP_REST_Request $request): void
	{
		$authToken = $request->get_param(AuthDataOptions::AUTH_TOKEN_OF_SECONDARY_USER_KEY);
		if (!is_string($authToken)) {
			throw new InternalDataException('Secondary auth token is not a valid type. Expected string', [
				'givenType' => gettype($authToken),
			]);
		}
		$currentSecondaryToken = self::getSecondaryToken();
		if (!$currentSecondaryToken) {
			throw new InternalDataException('Secondary auth token is not found in database');
		}

		if ($currentSecondaryToken !== $authToken) {
			throw new InternalDataException( 'Secondary auth token is not valid', ['invalidToken' => $authToken]);
		}
	}

	public static function getSecondaryToken(): ?string
	{
		return SecondaryUserTokenOption::get();
	}

	public static function saveSecondaryUserTokenByFirstUser(MeQrUserEntity $meQrUser): void
    {
	    if (self::getSecondaryToken() || $meQrUser->isPermanentUser()) {
		    return;
	    }

	    SecondaryUserTokenOption::save($meQrUser->getAuthToken());
    }
}