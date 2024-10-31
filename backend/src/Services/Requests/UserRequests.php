<?php declare(strict_types=1);

namespace Me_Qr\Services\Requests;

use Me_Qr\Exceptions\InternalDataException;
use Me_Qr\Services\Auth\AuthTokenService;
use Me_Qr\Services\Packages\HttpClient\AbstractRequest;
use Me_Qr\Services\Packages\HttpClient\ResponseData;

class UserRequests extends AbstractRequest
{
	/**
     * @throws InternalDataException
     */
    public function sendUserRegistrationRequest(): ResponseData
    {
        if (defined('ME_QR_CUSTOM_DEV_SITE_URL') && ME_QR_CUSTOM_DEV_SITE_URL) {
            $siteUrl = ME_QR_CUSTOM_DEV_SITE_URL;
        } else {
            $siteUrl = get_site_url();
        }

		$adminUrl = get_option('admin_email', null);
		if (!$adminUrl) {
			throw new InternalDataException('Could not determine admin email');
		}
        if ($siteUrl === '') {
            throw new InternalDataException('Could not determine the site url');
        }

        $data = [
	        'lastAuthToken' => AuthTokenService::getSecondaryToken(),
            'userEmail' => $adminUrl,
            'siteUrl' => $siteUrl,
        ];

        $response = $this->createPostRequest(ME_QR_REGISTRATION_SECONDARY_USER_URL, $data, true);
        if (!$response->isOk()) {
            throw new InternalDataException(
                'Me-Qr plugin error (creation secondary user request)| ' . $response->getMessage(),
                array_merge($response->getData(), [
                    'response_code' => $response->getCode(),
                    'request_link' => ME_QR_IMPORT_SETTINGS_REQUEST_URL,
                ])
            );
        }

        return $response;
    }
}
