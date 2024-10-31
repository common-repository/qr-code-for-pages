<?php

namespace Me_Qr\Services\Auth;

use Me_Qr\Entity\MeQrUserEntity;
use Me_Qr\Entity\Options\MeQrUserOption;
use Me_Qr\Exceptions\InternalDataException;
use Me_Qr\Repository\MeQrUserRepository;
use Me_Qr\Services\Auth\DTO\MeQrUserAuthDTOBuilder;
use Me_Qr\Services\Requests\UserRequests;

class MeQrUserService
{
    private UserRequests $userRequests;
    private MeQrUserAuthDTOBuilder $meQrUserAuthDTOBuilder;

    public function __construct(
        UserRequests $userRequests,
        MeQrUserAuthDTOBuilder $meQrUserAuthDTOBuilder
    ) {
        $this->userRequests = $userRequests;
        $this->meQrUserAuthDTOBuilder = $meQrUserAuthDTOBuilder;
    }

    public function checkPermanentUser(): bool
    {
        $currentMeQrUser = MeQrUserRepository::findEntity();
        if (!$currentMeQrUser) {
            return false;
        }

        return $currentMeQrUser->isPermanentUser();
    }

    /**
     * @throws InternalDataException
     */
    public function checkReqPermanentUser(): void
    {
        $currentMeQrUser = MeQrUserRepository::findRequiredEntity();
        if (!$currentMeQrUser->isPermanentUser()) {
            throw new InternalDataException('A permanent authorized Me-Qr user is required for the current operation');
        }
    }

    /**
     * @throws InternalDataException
     */
    public function registerSecondaryUser(): MeQrUserEntity
    {
        $responseData = $this->userRequests->sendUserRegistrationRequest()->getData();

        $userAuthDTO = $this->meQrUserAuthDTOBuilder->buildByArrayData($responseData);

        $user = MeQrUserRepository::buildEntity(
			$userAuthDTO->getAuthToken(),
            $userAuthDTO->getQrToken(),
            $userAuthDTO->getUsername(),
            false,
	        false,
        );
	    AuthTokenService::saveSecondaryUserTokenByFirstUser($user);
	    MeQrUserRepository::saveEntity($user);

        return $user;
    }

    public function uninstallUser(): void
    {
        $currentMeQrUser = MeQrUserRepository::findEntity();
        if (!$currentMeQrUser) {
            return;
        }

        MeQrUserOption::delete();
    }
}