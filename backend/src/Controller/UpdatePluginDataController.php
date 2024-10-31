<?php

namespace Me_Qr\Controller;

use Me_Qr\Exceptions\InternalDataException;
use Me_Qr\Services\Auth\AuthTokenService;
use Me_Qr\Services\Auth\DTO\MeQrUserAuthDTOBuilder;
use Me_Qr\Services\Auth\Update\DTO\UpdateUserPremiumDTOBuilder;
use Me_Qr\Services\Auth\Update\UpdatePluginDataService;
use Me_Qr\Services\ErrorHandler\ErrorHandlerService;
use Me_Qr\Services\Packages\Response\BadResponse;
use Me_Qr\Services\Packages\Response\SuccessResponse;
use Me_Qr\Services\Packages\Response\SystemErrorResponse;
use Me_Qr\Services\PluginSettings\Backup\DTO\PluginBackupDateDTOBuilder;
use Me_Qr\Services\PluginSettings\Backup\PluginBackupInfoService;
use Throwable;
use WP_REST_Controller;
use WP_REST_Request;
use WP_REST_Response;

class UpdatePluginDataController extends WP_REST_Controller
{
	private ErrorHandlerService $errorHandlerService;
    private UpdatePluginDataService $updatePluginDataService;
    private PluginBackupInfoService $pluginBackupInfoService;
    private MeQrUserAuthDTOBuilder $meQrUserAuthDTOBuilder;
    private PluginBackupDateDTOBuilder $pluginBackupDateDTOBuilder;
    private UpdateUserPremiumDTOBuilder $updateUserPremiumDTOBuilder;

	public function __construct(
        ErrorHandlerService $errorHandlerService,
        UpdatePluginDataService $updatePluginDataService,
        PluginBackupInfoService $pluginBackupInfoService,
        MeQrUserAuthDTOBuilder $meQrUserAuthDTOBuilder,
        PluginBackupDateDTOBuilder $pluginBackupDateDTOBuilder,
        UpdateUserPremiumDTOBuilder $updateUserPremiumDTOBuilder
    ) {
        $this->errorHandlerService = $errorHandlerService;
        $this->updatePluginDataService = $updatePluginDataService;
        $this->pluginBackupInfoService = $pluginBackupInfoService;
        $this->meQrUserAuthDTOBuilder = $meQrUserAuthDTOBuilder;
        $this->pluginBackupDateDTOBuilder = $pluginBackupDateDTOBuilder;
        $this->updateUserPremiumDTOBuilder = $updateUserPremiumDTOBuilder;
        $this->namespace = 'me-qr/api/update';
	}

	public function register_routes(): void
    {
        register_rest_route($this->namespace, "/auth-data", [
            'methods'  => 'POST',
            'permission_callback' => '__return_true',
            'callback' => [$this, 'updateAuthData'],
        ]);

        register_rest_route($this->namespace, "/premium-status", [
            'methods'  => 'POST',
            'permission_callback' => '__return_true',
            'callback' => [$this, 'updatePremiumStatus'],
        ]);

        register_rest_route($this->namespace, "/backup-data", [
            'methods'  => 'POST',
            'permission_callback' => '__return_true',
            'callback' => [$this, 'updateBackupData'],
        ]);
    }

    public function updateAuthData(WP_REST_Request $request): WP_REST_Response
    {
        try {
	        AuthTokenService::checkSecondaryAuthTokenByRequest($request);
            $userAuthDTO = $this->meQrUserAuthDTOBuilder->buildByArrayData($request->get_params());
            $backupDateDTO = $this->pluginBackupDateDTOBuilder->buildByArrayData($request->get_params());

            $this->updatePluginDataService->updateAuthData($userAuthDTO);
            $this->pluginBackupInfoService->saveExportDate($backupDateDTO->getBackupDateUTC());

            return new SuccessResponse();
        } catch (InternalDataException $e) {
            $this->errorHandlerService->writeExceptionToLog($e);
            return new BadResponse($e->getMessage());
        } catch (Throwable $e) {
            $this->errorHandlerService->handleException($e);
            return new SystemErrorResponse();
        }
    }

	public function updatePremiumStatus(WP_REST_Request $request): WP_REST_Response
	{
	    try {
		    AuthTokenService::checkAuthTokenByRequest($request);
	        $userAuthDTO = $this->updateUserPremiumDTOBuilder->buildByArrayData($request->get_params());
	        $this->updatePluginDataService->updatePremiumStatus($userAuthDTO);

	        return new SuccessResponse();
	    } catch (InternalDataException $e) {
	        $this->errorHandlerService->writeExceptionToLog($e);
	        return new BadResponse($e->getMessage());
	    } catch (Throwable $e) {
	        $this->errorHandlerService->handleException($e);
	        return new SystemErrorResponse();
	    }
	}

    public function updateBackupData(WP_REST_Request $request): WP_REST_Response
    {
        try {
	        AuthTokenService::checkAuthTokenByRequest($request);
            $backupDateDTO = $this->pluginBackupDateDTOBuilder->buildByArrayData($request->get_params());
            $backupDate = $backupDateDTO->getBackupDateUTC();
            if (!$backupDate) {
                throw new InternalDataException('No backup date data was received');
            }
            $this->pluginBackupInfoService->saveExportDate($backupDate);

            return new SuccessResponse();
        } catch (InternalDataException $e) {
            $this->errorHandlerService->writeExceptionToLog($e);
            return new BadResponse($e->getMessage());
        } catch (Throwable $e) {
            $this->errorHandlerService->handleException($e);
            return new SystemErrorResponse();
        }
    }
}
