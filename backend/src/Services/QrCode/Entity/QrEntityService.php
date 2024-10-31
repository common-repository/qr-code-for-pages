<?php

namespace Me_Qr\Services\QrCode\Entity;

use Me_Qr\Entity\QrCodeEntity;
use Me_Qr\Repository\QrCodesEntityRepository;

class QrEntityService
{
	public function saveQr(int $postId, int $qrCodeId): QrCodeEntity
	{
		$qrCodes = QrCodesEntityRepository::findEntity();
		$savedQrCode = null;

		foreach ($qrCodes->getAllQrs() as $qrCode) {
			if ($qrCode->getPostId() === $postId) {
				$qrCode->setQrCodeId($qrCodeId);
				$savedQrCode = $qrCode;
				break;
			}
		}

		if (!$savedQrCode) {
			$savedQrCode = new QrCodeEntity();
			$savedQrCode->setPostId($postId);
			$savedQrCode->setQrCodeId($qrCodeId);
			$qrCodes->addQr($savedQrCode);
		}

		QrCodesEntityRepository::saveEntity($qrCodes);

		return $savedQrCode;
	}

	public function deleteQrByPostId(int $postId): void
	{
		$qrCodes = QrCodesEntityRepository::findEntity();
		$deletedQrCode = null;

		foreach ($qrCodes->getAllQrs() as $qrCode) {
			if ($qrCode->getPostId() === $postId) {
				$deletedQrCode = $qrCode;
				break;
			}
		}
		if (!$deletedQrCode) {
			return;
		}

		$qrCodes->deleteQr($deletedQrCode);
		QrCodesEntityRepository::saveEntity($qrCodes);
	}
}