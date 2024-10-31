<?php

namespace Me_Qr\Controller;

use Me_Qr\Exceptions\InternalDataException;
use Me_Qr\Services\ErrorHandler\ErrorHandlerService;
use Me_Qr\Services\Packages\Response\BadResponse;
use Me_Qr\Services\Packages\Response\SuccessResponse;
use Me_Qr\Services\Packages\Response\SystemErrorResponse;
use Me_Qr\Services\QrCode\Loading\Provider\QrProvider;
use Throwable;
use WP_REST_Controller;
use WP_REST_Request;
use WP_REST_Response;

class QrCodeLinkController extends WP_REST_Controller
{
    private QrProvider $qrProvider;
    private ErrorHandlerService $errorHandlerService;

    public function __construct(
        QrProvider $qrProvider,
        ErrorHandlerService $errorHandlerService
    ) {
        $this->qrProvider = $qrProvider;
        $this->errorHandlerService = $errorHandlerService;
        $this->namespace = 'me-qr/api';
    }

    public function register_routes(): void
    {
        register_rest_route($this->namespace, "/get/qr", [
            'methods'  => 'POST',
            'permission_callback' => '__return_true',
            'callback' => [$this, 'getOneQrFormat'],
            'args'     => [
                'postId' => [
                    'type' => 'integer',
                    'required' => true,
                    'message' => 'Required post id not specified',
                ],
                'format' => [
                    'type' => 'string',
                    'required' => false,
                    'validate_callback' => static function($param) {
                        if (!in_array($param, ME_QR_VALID_QR_FORMATS, true)) {
                            return false;
                        }

                        return true;
                    },
                    'message' => "Available qr code format values: 'png', 'svg'",
                ],
            ],
        ]);

        register_rest_route($this->namespace, "/get/all-qr", [
            'methods'  => 'POST',
            'permission_callback' => '__return_true',
            'callback' => [$this, 'getAllQrByLink'],
            'args'     => [
                'postId' => [
                    'type' => 'integer',
                    'required' => true,
                    'message' => 'Required post id not specified',
                ],
            ],
        ]);

        register_rest_route($this->namespace, "/update/all-qr", [
            'methods'  => 'POST',
            'permission_callback' => '__return_true',
            'callback' => [$this, 'updateAllQr'],
            'args'     => [
                'postId' => [
                    'type' => 'integer',
                    'required' => true,
                    'message' => 'Required post id not specified',
                ],
            ],
        ]);
    }

    public function getOneQrFormat(WP_REST_Request $request): WP_REST_Response
    {
        try {
            $postId = $request->get_param('postId');
            $format = $request->get_param('format');
            $link = get_permalink($postId);
            if (!$link) {
                throw new InternalDataException('Post with given id was not found or does not exist');
            }
            if (!in_array($format, ME_QR_VALID_QR_FORMATS, true)) {
                throw new InternalDataException('The specified format does not match the valid formats');
            }

            $qrProviderDTO = $this->qrProvider->getOneQrFormat($postId, $link, $format);

            return new SuccessResponse($qrProviderDTO->toResponseArray());
        } catch (InternalDataException $e) {
            $this->errorHandlerService->handleException($e);
            return new BadResponse();
        } catch (Throwable $e) {
            $this->errorHandlerService->handleException($e);
            return new SystemErrorResponse();
        }
    }

    public function getAllQrByLink(WP_REST_Request $request): WP_REST_Response
    {
        try {
            $postId = $request->get_param('postId');
            $link = get_permalink($postId);
            if (!$link) {
                throw new InternalDataException('Post with given id was not found or does not exist');
            }

            $allQrFormatProviderDTO = $this->qrProvider->getAllQrFormats($postId, $link);

            return new SuccessResponse($allQrFormatProviderDTO->toResponseArray());
        } catch (InternalDataException $e) {
            $this->errorHandlerService->handleException($e);
            return new BadResponse();
        } catch (Throwable $e) {
            $this->errorHandlerService->handleException($e);
            return new SystemErrorResponse();
        }
    }

    public function updateAllQr(WP_REST_Request $request): WP_REST_Response
    {
        try {
            $postId = $request->get_param('postId');
            $link = get_permalink($postId);
            if (!$link) {
                throw new InternalDataException('Post with given id was not found or does not exist');
            }

            $allQrFormatProviderDTO = $this->qrProvider->updateAllQrFormatsByLink($postId, $link);

	        return new SuccessResponse($allQrFormatProviderDTO->toResponseArray());
        } catch (InternalDataException $e) {
            $this->errorHandlerService->handleException($e);
            return new BadResponse();
        } catch (Throwable $e) {
            $this->errorHandlerService->handleException($e);
            return new SystemErrorResponse();
        }
    }
}
