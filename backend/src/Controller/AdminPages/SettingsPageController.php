<?php

namespace Me_Qr\Controller\AdminPages;

use Me_Qr\Exceptions\InternalDataException;
use Me_Qr\Services\Auth\MeQrUserService;
use Me_Qr\Services\ErrorHandler\ErrorHandlerService;
use Me_Qr\Services\Packages\Response\BadResponse;
use Me_Qr\Services\Packages\Response\SuccessResponse;
use Me_Qr\Services\Packages\Response\SystemErrorResponse;
use Me_Qr\Services\Packages\Validator\Exceptions\ValidationExceptionInterface;
use Me_Qr\Services\PluginSettings\Backup\PluginBackupService;
use Me_Qr\Services\PluginSettings\DTO\SettingsPageDTOBuilder;
use Me_Qr\Services\PluginSettings\PluginSettingsService;
use Throwable;
use WP_REST_Controller;
use WP_REST_Request;
use WP_REST_Response;

class SettingsPageController extends WP_REST_Controller
{
    private MeQrUserService $meQrUserService;
    private PluginSettingsService $pluginSettingsService;
    private PluginBackupService $pluginBackupService;
    private ErrorHandlerService $errorHandlerService;
    private SettingsPageDTOBuilder $settingsPageDTOBuilder;

    public function __construct(
        MeQrUserService $meQrUserService,
        PluginSettingsService $pluginSettingsService,
        PluginBackupService $pluginBackupService,
        ErrorHandlerService $errorHandlerService,
        SettingsPageDTOBuilder $settingsPageDTOBuilder
    ) {
        $this->meQrUserService = $meQrUserService;
        $this->pluginSettingsService = $pluginSettingsService;
        $this->pluginBackupService = $pluginBackupService;
        $this->errorHandlerService = $errorHandlerService;
        $this->settingsPageDTOBuilder = $settingsPageDTOBuilder;
        $this->namespace = 'me-qr/api';
    }

    public function register_routes(): void
    {
        register_rest_route($this->namespace, "/save/settings", [
            'methods'  => 'POST',
            'permission_callback' => function() {
                return current_user_can('edit_others_posts');
            },
            'callback' => [$this, 'saveSettings'],
        ]);

        register_rest_route($this->namespace, "/export/settings", [
            'methods'  => 'POST',
            'permission_callback' => function() {
                return current_user_can('edit_others_posts');
            },
            'callback' => [$this, 'exportSettings'],
        ]);

        register_rest_route($this->namespace, "/import/settings", [
            'methods'  => 'POST',
            'permission_callback' => function() {
                return current_user_can('edit_others_posts');
            },
            'callback' => [$this, 'importSettings'],
            'args' => [
                'checkedBackupWpUserId' => [
                    'type' => ['integer', 'null'],
                    'required' => false,
                    'default' => null,
                ],
            ],
        ]);
    }

    public function saveSettings(WP_REST_Request $request): WP_REST_Response
    {
        try {
            $dataDTO = $this->settingsPageDTOBuilder->buildByRequestDate($request->get_params());
            $this->pluginSettingsService->saveSettings($dataDTO);

            return new SuccessResponse();
        } catch (ValidationExceptionInterface $e) {
            return new BadResponse($e->getMessage());
        } catch (Throwable $e) {
            $this->errorHandlerService->handleException($e);
            return new SystemErrorResponse();
        }
    }

    public function exportSettings(): WP_REST_Response
    {
        try {
            $this->meQrUserService->checkReqPermanentUser();
            $exportDate = $this->pluginBackupService->exportSettings();

            return new SuccessResponse([
                'exportDate' => $exportDate,
            ]);
        } catch (InternalDataException $e) {
            $this->errorHandlerService->writeExceptionToLog($e);
            return new BadResponse();
        } catch (Throwable $e) {
            $this->errorHandlerService->handleException($e);
            return new SystemErrorResponse();
        }
    }

    public function importSettings(): WP_REST_Response
    {
        try {
            $this->meQrUserService->checkReqPermanentUser();
            $this->pluginBackupService->importSettings();

            return new SuccessResponse();
        } catch (InternalDataException $e) {
            $this->errorHandlerService->writeExceptionToLog($e);
            return new BadResponse();
        } catch (Throwable $e) {
            $this->errorHandlerService->handleException($e);
            return new SystemErrorResponse();
        }
    }
}
