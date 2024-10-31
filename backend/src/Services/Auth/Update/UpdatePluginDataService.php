<?php

namespace Me_Qr\Services\Auth\Update;

use Me_Qr\Exceptions\InternalDataException;
use Me_Qr\Repository\MeQrUserRepository;
use Me_Qr\Services\Auth\DTO\MeQrUserAuthDTO;
use Me_Qr\Services\Auth\Update\DTO\UpdateUserPremiumDTO;
use Me_Qr\Services\ErrorHandler\ErrorHandlerService;
use Throwable;

class UpdatePluginDataService
{
    private ErrorHandlerService $errorHandlerService;

    public function __construct(
        ErrorHandlerService $errorHandlerService
    ) {
        $this->errorHandlerService = $errorHandlerService;
    }

    public function updateAuthData(MeQrUserAuthDTO $userAuthDTO): void
    {
        try {
            $user = MeQrUserRepository::buildEntity(
				$userAuthDTO->getAuthToken(),
                $userAuthDTO->getQrToken(),
                $userAuthDTO->getUsername(),
                true,
                $userAuthDTO->getPremiumUserValue(),
            );

	        MeQrUserRepository::saveEntity($user);
        } catch (Throwable $e) {
            $this->errorHandlerService->handleException($e, true, false);
        }
    }

    public function updatePremiumStatus(UpdateUserPremiumDTO $updateUserPremiumDTO): void
    {
        try {
            $user = MeQrUserRepository::findEntity();
            if (!$user) {
                throw new InternalDataException('The user was not found in the database');
            }

            $user->setIsUserPremium($updateUserPremiumDTO->getPremiumUserValue());
	        MeQrUserRepository::saveEntity($user);
        } catch (Throwable $e) {
            $this->errorHandlerService->handleException($e, true, false);
        }
    }
}