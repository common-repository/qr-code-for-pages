<?php

namespace Me_Qr\Core;

use Exception;
use Me_Qr\Entity\Options\BackupInfoOption;
use Me_Qr\Entity\Options\PluginSettingsOption;
use Me_Qr\Entity\Options\QrCodesOption;
use Me_Qr\Entity\Options\UniqueExceptionOption;
use Me_Qr\Services\Auth\MeQrUserService;
use Me_Qr\Services\ErrorHandler\ErrorHandlerService;
use Me_Qr\Services\File\UploadDirectoryService;

class MeQrPluginUninstallExecute
{
    private ErrorHandlerService $errorHandlerService;
    private MeQrUserService $meQrUserService;

    public function __construct(
        ErrorHandlerService $errorHandlerService,
        MeQrUserService $meQrUserService
    ) {
        $this->errorHandlerService = $errorHandlerService;
        $this->meQrUserService = $meQrUserService;
    }

    public function execute(): void
    {
        try {
            PluginSettingsOption::delete();
            BackupInfoOption::delete();
	        QrCodesOption::delete();
            UploadDirectoryService::deleteQrDirectory();
            UploadDirectoryService::deleteMeQrContentDirectory();
            UniqueExceptionOption::delete();
            $this->meQrUserService->uninstallUser();
        } catch (Exception $e) {
            $this->errorHandlerService->handleException($e);
        }
    }
}
