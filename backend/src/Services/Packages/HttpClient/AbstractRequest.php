<?php declare(strict_types=1);

namespace Me_Qr\Services\Packages\HttpClient;

use Throwable;
use WP_Error;

abstract class AbstractRequest
{
    protected function createPostRequest(string $url, array $data, bool $isJsonRequest = false): ResponseData
    {
        if ($isJsonRequest) {
            $contentType = 'application/json';
            $requestData = json_encode($data);
        } else {
            $contentType = 'application/x-www-form-urlencoded';
            $requestData = $data;
        }

        $response = wp_remote_post($url, [
            'headers' => [
                'content-type' => $contentType,
            ],
            'body' => $requestData,
            'timeout' => ME_QR_REQUEST_TIMEOUT,
        ]);

        if ($response instanceof WP_Error) {
            return $this->handelWpError($response);
        }

        $responseCode = $this->getResponseCodeByResponse($response);
        if ($responseCode >= 400 && $responseCode <= 599) {
            return $this->handelResponseError($responseCode, $response);
        }
        if ($responseCode >= 200 && $responseCode <= 299) {
            return $this->handelResponseSuccess($response);
        }

        return ResponseData::create(
            $responseCode,
            "External request error. Unable to handle error code '$responseCode'",
        );
    }

    private function handelWpError(WP_Error $response): ResponseData
    {
        $errorCode = $response->get_error_code();
        if (is_string($errorCode)) {
            $errorCode = 0;
        }

        return ResponseData::create(
            $errorCode,
            "Request failed with message: " . $response->get_error_message()
        );
    }

    private function handelResponseError(int $responseCode, array $response): ResponseData
    {
        $responseBody = $this->getResponseBodyByResponse($response);
        $message =
            $responseBody['message'] ??
            $responseBody['error'] ??
            $responseBody['description'] ??
            "Unknown error"
        ;

        return ResponseData::create($responseCode, "Request failed with message: $message", $responseBody);
    }

    private function handelResponseSuccess(array $response): ResponseData
    {
        $responseBody = $this->getResponseBodyByResponse($response);
        $message = $responseBody['message'] ?? null;
        $data = $responseBody['data'] ?? $responseBody;

        return ResponseData::create(200, $message, $data);
    }

    private function getResponseCodeByResponse(array $response): int
    {
        $responseCode = ($response['response'] ?? [])['code'] ?? null;
        if ($responseCode) {
            return $responseCode;
        }

        return 0;
    }

    private function getResponseBodyByResponse(array $response): array
    {
        try {
            $responseBody = $response['body'] ?? null;
            if (!$responseBody) {
                return [];
            }
            if (is_string($responseBody)) {
                $decodedResponseBody = json_decode($responseBody, true);
                if (!$decodedResponseBody) {
                    $responseBody = [
                        'response_body_content' => substr($responseBody, 0, 100) . '...',
                    ];
                } else {
                    $responseBody = $decodedResponseBody;
                }
            }
            if (!is_array($responseBody)) {
                return [];
            }

            return $responseBody;
        } catch (Throwable $e) {
            return [];
        }
    }
}