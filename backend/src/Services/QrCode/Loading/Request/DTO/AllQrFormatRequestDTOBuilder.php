<?php

namespace Me_Qr\Services\QrCode\Loading\Request\DTO;

use Me_Qr\Exceptions\InternalDataException;
use Me_Qr\Services\Packages\Validator\MeQrValidator;
use Me_Qr\Services\QrCode\Loading\Request\QrRequestOptions;

class AllQrFormatRequestDTOBuilder
{
    private MeQrValidator $meQrValidator;

    public function __construct(MeQrValidator $meQrValidator)
    {
        $this->meQrValidator = $meQrValidator;
    }

    /**
     * @throws InternalDataException
     */
    public function buildByRequestData(array $requestData): AllQrFormatRequestDTO
    {
		$qrCodesArr = $requestData[QrRequestOptions::QR_CODES_RESPONSE_KEY] ?? [];

        $dto = new AllQrFormatRequestDTO(
	        $requestData[QrRequestOptions::QR_CODE_ID_RESPONSE_KEY] ?? null,
	        $qrCodesArr[QrRequestOptions::PNG_QR_RESPONSE_KEY] ?? null,
	        $qrCodesArr[QrRequestOptions::SVG_QR_RESPONSE_KEY] ?? null,
        );

        $exceptions = $this->meQrValidator->validate($dto);
        if ($exceptions->isExceptions()) {
            throw new InternalDataException($exceptions->getExceptionString());
        }

        return $dto;
    }
}
