<?php

namespace Me_Qr\Controller;

use Me_Qr\Services\Auth\LogoutService;
use Me_Qr\Services\ErrorHandler\ErrorHandlerService;
use Me_Qr\Services\Packages\Response\SuccessResponse;
use Me_Qr\Services\Packages\Response\SystemErrorResponse;
use Throwable;
use WP_REST_Controller;
use WP_REST_Response;

class AccountController extends WP_REST_Controller
{
    private LogoutService $logoutService;
    private ErrorHandlerService $errorHandlerService;

    public function __construct(
        LogoutService $logoutService,
        ErrorHandlerService $errorHandlerService
    ) {
        $this->logoutService = $logoutService;
        $this->errorHandlerService = $errorHandlerService;
        $this->namespace = 'me-qr/api';
    }

    public function register_routes(): void
    {
        register_rest_route($this->namespace, "/account/logout", [
            'methods'  => 'POST',
            'permission_callback' => function() {
                return current_user_can('edit_others_posts');
            },
            'callback' => [$this, 'accountLogout'],
        ]);
    }

    public function accountLogout(): WP_REST_Response
    {
        try {
            $this->logoutService->accountLogout();

            return new SuccessResponse();
        } catch (Throwable $e) {
            $this->errorHandlerService->handleException($e);
            return new SystemErrorResponse();
        }
    }
}
