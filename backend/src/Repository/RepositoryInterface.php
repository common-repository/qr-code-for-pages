<?php

namespace Me_Qr\Repository;

use Me_Qr\Entity\EntityInterface;

interface RepositoryInterface
{
    public static function findEntity();

    public static function saveEntity(?EntityInterface $entity): bool;
}