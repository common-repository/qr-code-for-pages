<?php

namespace Me_Qr\Services\Auth\DTO;

use Me_Qr\Exceptions\InternalDataException;
use Me_Qr\Services\Auth\AuthDataOptions;
use Me_Qr\Services\Packages\Validator\MeQrValidator;

class MeQrUserAuthDTOBuilder
{
    private MeQrValidator $meQrValidator;

    public function __construct(
        MeQrValidator $meQrValidator
    ) {
        $this->meQrValidator = $meQrValidator;
    }

    /**
     * @throws InternalDataException
     */
    public function build($authToken, $qrToken, $username, $premiumUserValue): MeQrUserAuthDTO
    {
        $dto = new MeQrUserAuthDTO($authToken, $qrToken, $username, $premiumUserValue);

        $exceptions = $this->meQrValidator->validate($dto);
        if ($exceptions->isExceptions()) {
            throw new InternalDataException($exceptions->getExceptionString());
        }

        return $dto;
    }

    /**
     * @throws InternalDataException
     */
    public function buildByArrayData(array $data): MeQrUserAuthDTO
    {
        return $this->build(
            $data[AuthDataOptions::AUTH_TOKEN_KEY] ?? null,
            $data[AuthDataOptions::QR_TOKEN_KEY] ?? null,
            $data[AuthDataOptions::USERNAME_KEY] ?? null,
            $data[AuthDataOptions::IS_PREMIUM_KEY] ?? null,
        );
    }
}