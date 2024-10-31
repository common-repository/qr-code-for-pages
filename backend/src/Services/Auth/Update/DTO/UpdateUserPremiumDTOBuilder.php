<?php

namespace Me_Qr\Services\Auth\Update\DTO;

use Me_Qr\Exceptions\InternalDataException;
use Me_Qr\Services\Auth\AuthDataOptions;
use Me_Qr\Services\Packages\Validator\MeQrValidator;

class UpdateUserPremiumDTOBuilder
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
    public function build(
        $premiumUserValue
    ): UpdateUserPremiumDTO {
        $dto = new UpdateUserPremiumDTO($premiumUserValue);

        $exceptions = $this->meQrValidator->validate($dto);
        if ($exceptions->isExceptions()) {
            throw new InternalDataException($exceptions->getExceptionString());
        }

        return $dto;
    }

    /**
     * @throws InternalDataException
     */
    public function buildByArrayData(array $data): UpdateUserPremiumDTO
    {
        return $this->build(
            $data[AuthDataOptions::IS_PREMIUM_KEY] ?? null,
        );
    }
}