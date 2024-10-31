<?php

namespace Me_Qr\Services\QrCode\Loading\Request\DTO;

use Me_Qr\Exceptions\InternalDataException;
use Me_Qr\Services\Packages\Validator\MeQrValidator;
use Me_Qr\Services\QrCode\Loading\Request\QrRequestOptions;

class OneQrFormatRequestDTOBuilder
{
    private MeQrValidator $meQrValidator;

    public function __construct(MeQrValidator $meQrValidator)
    {
        $this->meQrValidator = $meQrValidator;
    }

    /**
     * @throws InternalDataException
     */
    public function buildByRequestData(array $requestData): OneQrFormatRequestDTO
    {
        $dto = new OneQrFormatRequestDTO(
	        $requestData[QrRequestOptions::QR_CODE_ID_RESPONSE_KEY] ?? null,
	        $requestData[QrRequestOptions::QR_CODE_RESPONSE_KEY] ?? null,
        );

        $exceptions = $this->meQrValidator->validate($dto);
        if ($exceptions->isExceptions()) {
            throw new InternalDataException($exceptions->getExceptionString());
        }

        return $dto;
    }
}
