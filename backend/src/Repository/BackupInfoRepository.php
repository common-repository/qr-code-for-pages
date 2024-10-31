<?php

namespace Me_Qr\Repository;

use Me_Qr\Entity\BackupInfoEntity;
use Me_Qr\Entity\EntityInterface;
use Me_Qr\Entity\Options\BackupInfoOption;

class BackupInfoRepository implements RepositoryInterface
{
    public static function buildEntity(?string $exportDate, ?string $importDate): BackupInfoEntity
    {
        $entity = new BackupInfoEntity();
        $entity->setExportDate($exportDate);
        $entity->setImportDate($importDate);

        return $entity;
    }

    public static function findEntity(): BackupInfoEntity
    {
        $emptyEntity = new BackupInfoEntity();
        $entityData = BackupInfoOption::get();
        if (!$entityData) {
            return $emptyEntity;
        }

        return self::buildEntity(
            $entityData[BackupInfoEntity::EXPORT_DATE_KEY],
            $entityData[BackupInfoEntity::IMPORT_DATE_KEY],
        );
    }

    public static function saveEntity(?EntityInterface $entity): bool
    {
        return BackupInfoOption::save($entity->jsonSerialize());
    }
}