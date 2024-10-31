<?php declare(strict_types=1);

namespace Me_Qr\Services\Requests;

use Me_Qr\Exceptions\InternalDataException;
use Me_Qr\Services\Auth\AuthDataOptions;
use Me_Qr\Services\Packages\HttpClient\AbstractRequest;
use Me_Qr\Services\Packages\HttpClient\ResponseData;
use Me_Qr\Services\PluginSettings\PluginSettingsOptions;

class PluginSettingsRequests extends AbstractRequest
{
    /**
     * @throws InternalDataException
     */
    public function createExportRequest(
        string $authToken,
        ?string $shtBlockClass,
        ?string $shtImgClass,
        bool $fileLoggingValue,
        bool $tgLoggingValue
    ): ResponseData {
        $data = [
            AuthDataOptions::AUTH_TOKEN_KEY => $authToken,
            PluginSettingsOptions::QR_BLOCK_CLASS_OPTION => $shtBlockClass,
            PluginSettingsOptions::QR_IMG_CLASS_OPTION => $shtImgClass,
            PluginSettingsOptions::FILE_LOGGING_OPTION => $fileLoggingValue,
            PluginSettingsOptions::TG_LOGGING_OPTION => $tgLoggingValue,
        ];

        $response = $this->createPostRequest(ME_QR_EXPORT_SETTINGS_REQUEST_URL, $data, true);
        if (!$response->isOk()) {
            throw new InternalDataException(
                'Me-Qr plugin error (export plugin settings request)| ' . $response->getMessage(),
                array_merge($response->getData(), [
                    'response_code' => $response->getCode(),
                    'request_link' => ME_QR_EXPORT_SETTINGS_REQUEST_URL,
                ])
            );
        }

        return $response;
    }

    /**
     * @throws InternalDataException
     */
    public function createImportRequest(
        string $authToken
    ): ResponseData {
        $data = [
            AuthDataOptions::AUTH_TOKEN_KEY => $authToken,
        ];

        $response = $this->createPostRequest(ME_QR_IMPORT_SETTINGS_REQUEST_URL, $data, true);
        if (!$response->isOk()) {
            throw new InternalDataException(
                'Me-Qr plugin error (import plugin settings request)| ' . $response->getMessage(),
                array_merge($response->getData(), [
                    'response_code' => $response->getCode(),
                    'request_link' => ME_QR_IMPORT_SETTINGS_REQUEST_URL,
                ])
            );
        }

        return $response;
    }
}
