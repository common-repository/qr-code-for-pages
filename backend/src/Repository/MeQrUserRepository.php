<?php

namespace Me_Qr\Repository;

use Me_Qr\Entity\EntityInterface;
use Me_Qr\Entity\MeQrUserEntity;
use Me_Qr\Entity\Options\MeQrUserOption;
use Me_Qr\Exceptions\InternalDataException;

class MeQrUserRepository implements RepositoryInterface
{
    public static function buildEntity(
        string $authToken,
        string $qrToken,
        ?string $username,
        bool $isPermanentUser,
        bool $isUserPremium
    ): MeQrUserEntity {
        $entity = new MeQrUserEntity();
        $entity->setAuthToken($authToken);
        $entity->setQrToken($qrToken);
        $entity->setUsername($username);
        $entity->setIsPermanentUser($isPermanentUser);
        $entity->setIsUserPremium($isUserPremium);

        return $entity;
    }

    public static function findEntity(): ?MeQrUserEntity
    {
        $entityData = MeQrUserOption::get();
        if (!$entityData) {
            return null;
        }

        return self::buildEntity(
	        $entityData[MeQrUserEntity::AUTH_TOKEN_KEY],
            $entityData[MeQrUserEntity::QR_TOKEN_KEY],
            $entityData[MeQrUserEntity::USERNAME_KEY],
            $entityData[MeQrUserEntity::IS_PERMANENT_USER_KEY],
            $entityData[MeQrUserEntity::IS_PREMIUM_KEY],
        );
    }

    /**
     * @throws InternalDataException
     */
    public static function findRequiredEntity(): MeQrUserEntity
    {
        $entity = self::findEntity();
        if (!$entity) {
            throw new InternalDataException('Error building the MeQrUserEntity from the database');
        }

        return $entity;
    }

    public static function saveEntity(?EntityInterface $entity): bool
    {
        return MeQrUserOption::save($entity->jsonSerialize());
    }
}