<?php declare(strict_types=1);

namespace Me_Qr\Services\Requests;

use Me_Qr\Exceptions\InternalDataException;
use Me_Qr\Services\Auth\AuthDataOptions;
use Me_Qr\Services\Packages\HttpClient\AbstractRequest;
use Me_Qr\Services\Packages\HttpClient\ResponseData;
use Me_Qr\Services\QrCode\Loading\Request\QrRequestOptions;

class QrRequests extends AbstractRequest
{
    /**
     * @throws InternalDataException
     */
    public function createQrRequest(string $qrToken, string $link, string $format, ?int $qrCodeId = null): ResponseData
    {
        $data = [
            AuthDataOptions::QR_TOKEN_KEY => $qrToken,
            QrRequestOptions::QR_LINK_REQUEST_KEY => $link,
            QrRequestOptions::QR_FORMAT_REQUEST_KEY => $format,
            QrRequestOptions::QR_ID_REQUEST_KEY => $qrCodeId,
        ];

        $response = $this->createPostRequest(ME_QR_GET_QR_REQUEST_URL, $data, true);
        if (!$response->isOk()) {
            throw new InternalDataException(
                'Me-Qr plugin error (creation one qr request)| ' . $response->getMessage(),
                array_merge($response->getData(), [
                    'response_code' => $response->getCode(),
                    'request_link' => ME_QR_GET_QR_REQUEST_URL,
                ])
            );
        }

        return $response;
    }

    /**
     * @throws InternalDataException
     */
    public function createAllQrRequest(string $qrToken, string $link, ?int $qrCodeId = null): ResponseData
    {
        $data = [
            AuthDataOptions::QR_TOKEN_KEY => $qrToken,
            QrRequestOptions::QR_LINK_REQUEST_KEY => $link,
            QrRequestOptions::QR_ID_REQUEST_KEY => $qrCodeId,
        ];

        $response = $this->createPostRequest(ME_QR_GET_ALL_QR_REQUEST_URL, $data, true);
        if (!$response->isOk()) {
            throw new InternalDataException(
                'Me-Qr plugin error (creation all qr request)| ' . $response->getMessage(),
                array_merge($response->getData(), [
                    'response_code' => $response->getCode(),
                    'request_link' => ME_QR_GET_ALL_QR_REQUEST_URL,
                ])
            );
        }

        return $response;
    }
}