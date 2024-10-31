<?php declare(strict_types=1);

namespace Me_Qr\Services\QrCode\Loading\Request;

use Me_Qr\Exceptions\InternalDataException;
use Me_Qr\Repository\MeQrUserRepository;
use Me_Qr\Services\QrCode\Loading\Request\DTO\AllQrFormatRequestDTO;
use Me_Qr\Services\QrCode\Loading\Request\DTO\AllQrFormatRequestDTOBuilder;
use Me_Qr\Services\QrCode\Loading\Request\DTO\OneQrFormatRequestDTO;
use Me_Qr\Services\QrCode\Loading\Request\DTO\OneQrFormatRequestDTOBuilder;
use Me_Qr\Services\Requests\QrRequests;

class QrRequestService
{
    private QrRequests $qrRequests;
    private OneQrFormatRequestDTOBuilder $oneQrFormatRequestDTOBuilder;
    private AllQrFormatRequestDTOBuilder $allQrFormatRequestDTOBuilder;

    public function __construct(
        QrRequests $qrRequests,
	    OneQrFormatRequestDTOBuilder $oneQrFormatRequestDTOBuilder,
        AllQrFormatRequestDTOBuilder $allQrFormatRequestDTOBuilder
    ) {
        $this->qrRequests = $qrRequests;
        $this->oneQrFormatRequestDTOBuilder = $oneQrFormatRequestDTOBuilder;
        $this->allQrFormatRequestDTOBuilder = $allQrFormatRequestDTOBuilder;
    }

    /**
     * @throws InternalDataException
     */
    public function getQrLinkOfOneFormat(string $link, string $format, ?int $qrCodeId = null): OneQrFormatRequestDTO
    {
        $user = MeQrUserRepository::findRequiredEntity();
        $responseData = $this->qrRequests->createQrRequest($user->getQrToken(), $link, $format, $qrCodeId);
        $qrCode = $responseData->get(QrRequestOptions::QR_CODE_RESPONSE_KEY);
        if (!$qrCode) {
            throw new InternalDataException('Qr code not received');
        }

	    return $this->oneQrFormatRequestDTOBuilder->buildByRequestData($responseData->getData());
    }

    /**
     * @throws InternalDataException
     */
    public function getQrLinkOfAllFormats(string $link, ?int $qrCodeId = null): AllQrFormatRequestDTO
    {
        $user = MeQrUserRepository::findRequiredEntity();
        $responseData = $this->qrRequests->createAllQrRequest($user->getQrToken(), $link, $qrCodeId);

        return $this->allQrFormatRequestDTOBuilder->buildByRequestData($responseData->getData());
    }
}