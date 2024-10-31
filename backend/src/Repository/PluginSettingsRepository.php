<?php

namespace Me_Qr\Repository;

use Me_Qr\Entity\EntityInterface;
use Me_Qr\Entity\Options\PluginSettingsOption;
use Me_Qr\Entity\PluginSettingsEntity;
use Me_Qr\Exceptions\InternalDataException;

class PluginSettingsRepository implements RepositoryInterface
{
    public static function buildEntity(
        ?string $qrBlockClass,
        ?string $qrImgClass,
        bool $isFileLogging,
        bool $isTgLogging
    ): PluginSettingsEntity {
        $entity = new PluginSettingsEntity();
        $entity->setQrBlockClass($qrBlockClass);
        $entity->setQrImgClass($qrImgClass);
        $entity->setIsFileLogging($isFileLogging);
        $entity->setIsTgLogging($isTgLogging);

        return $entity;
    }

    public static function findEntity(): ?PluginSettingsEntity
    {
        $entityData = PluginSettingsOption::get();
        if (!$entityData) {
            return null;
        }

        return self::buildEntity(
            $entityData[PluginSettingsEntity::QR_BLOCK_CLASS_KEY],
            $entityData[PluginSettingsEntity::QR_IMG_CLASS_KEY],
            $entityData[PluginSettingsEntity::FILE_LOGGING_KEY],
            $entityData[PluginSettingsEntity::TG_LOGGING_KEY],
        );
    }

    /**
     * @throws InternalDataException
     */
    public static function findRequiredEntity(): PluginSettingsEntity
    {
        $entity = self::findEntity();
        if (!$entity) {
            throw new InternalDataException('Error building the PluginSettingsEntity from the database');
        }

        return $entity;
    }

    public static function saveEntity(?EntityInterface $entity): bool
    {
        return PluginSettingsOption::save($entity->jsonSerialize());
    }
}