<?php

namespace Me_Qr\Repository;

use Me_Qr\Entity\Options\QrCodesOption;
use Me_Qr\Entity\QrCodeEntity;
use Me_Qr\Entity\QrCodesEntity;
use Me_Qr\Entity\EntityInterface;

class QrCodesEntityRepository implements RepositoryInterface
{
    public static function buildEntity(array $qrCodesEntityData = []): QrCodesEntity
    {
        $entity = new QrCodesEntity();
		$qrCodesArr = [];
		foreach ($qrCodesEntityData as $qrCodeEntityData) {
			$postId = $qrCodeEntityData[QrCodeEntity::POST_ID_KEY] ?? null;
			$qrCodeId = $qrCodeEntityData[QrCodeEntity::QR_CODE_KEY] ?? null;
			if (!$postId || !$qrCodeId) {
				continue;
			}

			$qrCodeEntity = new QrCodeEntity();
			$qrCodeEntity->setPostId($postId);
			$qrCodeEntity->setQrCodeId($qrCodeId);

			$qrCodesArr[] = $qrCodeEntity;
		}
        $entity->setAllQrs($qrCodesArr);

        return $entity;
    }

    public static function findEntity(): QrCodesEntity
    {
	    $qrCodesData = QrCodesOption::get();
        if ($qrCodesData === null) {
			$qrCodesData = [];
        }

        return self::buildEntity($qrCodesData);
    }

	public static function findQrCodeEntityByPostId(int $postId): ?QrCodeEntity
	{
		$qrCodes = self::findEntity();

		foreach ($qrCodes->getAllQrs() as $qrCode) {
			if ($qrCode->getPostId() === $postId) {
				return $qrCode;
			}
		}

		return null;
	}

    public static function saveEntity(?EntityInterface $entity): bool
    {
        return QrCodesOption::save($entity->jsonSerialize());
    }
}