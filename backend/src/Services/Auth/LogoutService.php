<?php

namespace Me_Qr\Services\Auth;

use Me_Qr\Exceptions\InternalDataException;

class LogoutService
{
    private MeQrUserService $meQrUserService;

    public function __construct(
        MeQrUserService $meQrUserService
    ) {
        $this->meQrUserService = $meQrUserService;
    }

    /**
     * @throws InternalDataException
     */
    public function accountLogout(): void
    {
        $this->meQrUserService->registerSecondaryUser();
    }
}