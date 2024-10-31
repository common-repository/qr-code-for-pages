<?php

namespace Me_Qr\Services\QrCode\Loading\Provider;

use Me_Qr\Exceptions\InternalDataException;
use Me_Qr\Repository\QrCodesEntityRepository;
use Me_Qr\Services\File\QrFileManager;
use Me_Qr\Services\QrCode\Loading\Provider\DTO\AllQrFormatProviderDTO;
use Me_Qr\Services\QrCode\Loading\Provider\DTO\AllQrFormatProviderDTOBuilder;
use Me_Qr\Services\QrCode\Loading\Provider\DTO\OneQrFormatProviderDTO;
use Me_Qr\Services\QrCode\Loading\Provider\DTO\OneQrFormatProviderDTOBuilder;
use Me_Qr\Services\QrCode\Loading\Request\QrRequestService;
use Me_Qr\Services\QrCode\Entity\QrEntityService;

class QrProvider
{
    private QrEntityService $qrEntityService;
	private QrFileManager $qrFileManager;
	private QrRequestService $qrRequestService;

    public function __construct(
	    QrEntityService $qrEntityService,
	    QrFileManager $qrFileManager,
	    QrRequestService $qrRequestService
    ) {
	    $this->qrEntityService = $qrEntityService;
	    $this->qrFileManager = $qrFileManager;
	    $this->qrRequestService = $qrRequestService;
    }

    /**
     * @throws InternalDataException
     */
    public function getOneQrFormat(int $postId, string $link, string $format): OneQrFormatProviderDTO
    {
        if (!$this->qrFileManager->isQrExists($postId, $format)) {
            $qrDTO = $this->qrRequestService->getQrLinkOfOneFormat($link, $format);
            $this->qrFileManager->saveQrByPostId($qrDTO->getQrCode(), $postId, $format);
			$this->qrEntityService->saveQr($postId, $qrDTO->getQrCodeId());
        }

        $qrCode = $this->qrFileManager->getQrLinkByPostId($postId, $format);
        return OneQrFormatProviderDTOBuilder::build($qrCode, $format);
    }

    /**
     * @throws InternalDataException
     */
    public function getAllQrFormats(int $postId, string $link): AllQrFormatProviderDTO
    {
        $isExistsQrPng = $this->qrFileManager->isQrExists($postId, ME_QR_PNG_FORMAT);
        $isExistsQrSvg = $this->qrFileManager->isQrExists($postId, ME_QR_SVG_FORMAT);
        if (!$isExistsQrPng || !$isExistsQrSvg) {
            $qrsDTO = $this->qrRequestService->getQrLinkOfAllFormats($link);
            $this->qrFileManager->saveQrByPostId($qrsDTO->getPngQr(), $postId, ME_QR_PNG_FORMAT);
            $this->qrFileManager->saveQrByPostId($qrsDTO->getSvgQr(), $postId, ME_QR_SVG_FORMAT);
	        $this->qrEntityService->saveQr($postId, $qrsDTO->getQrCodeId());
        }

        $pngQrLink = $this->qrFileManager->getQrLinkByPostId($postId, ME_QR_PNG_FORMAT);
        $svgQrLink = $this->qrFileManager->getQrLinkByPostId($postId, ME_QR_SVG_FORMAT);
        $qrPngProviderDTO = OneQrFormatProviderDTOBuilder::build($pngQrLink, ME_QR_PNG_FORMAT);
        $qrSvgProviderDTO = OneQrFormatProviderDTOBuilder::build($svgQrLink, ME_QR_SVG_FORMAT);

        return AllQrFormatProviderDTOBuilder::build($qrPngProviderDTO, $qrSvgProviderDTO);
    }

    /**
     * @throws InternalDataException
     */
    public function updateAllQrFormatsByLink(int $postId, string $link): AllQrFormatProviderDTO
    {
	    $qrCodeId = null;
		$qrCodeEntity = QrCodesEntityRepository::findQrCodeEntityByPostId($postId);
		if ($qrCodeEntity) {
			$qrCodeId = $qrCodeEntity->getQrCodeId();
		}

	    $qrsDTO = $this->qrRequestService->getQrLinkOfAllFormats($link, $qrCodeId);
        $this->qrFileManager->saveQrByPostId($qrsDTO->getPngQr(), $postId, ME_QR_PNG_FORMAT);
        $this->qrFileManager->saveQrByPostId($qrsDTO->getSvgQr(), $postId, ME_QR_SVG_FORMAT);
	    $this->qrEntityService->saveQr($postId, $qrsDTO->getQrCodeId());

        $pngQrLink = $this->qrFileManager->getQrLinkByPostId($postId, ME_QR_PNG_FORMAT);
        $svgQrLink = $this->qrFileManager->getQrLinkByPostId($postId, ME_QR_SVG_FORMAT);
        $qrPngProviderDTO = OneQrFormatProviderDTOBuilder::build($pngQrLink, ME_QR_PNG_FORMAT);
        $qrSvgProviderDTO = OneQrFormatProviderDTOBuilder::build($svgQrLink, ME_QR_SVG_FORMAT);

        return AllQrFormatProviderDTOBuilder::build($qrPngProviderDTO, $qrSvgProviderDTO);
    }
}
