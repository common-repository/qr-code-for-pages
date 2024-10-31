<?php

namespace Me_Qr\Entity;

use JsonSerializable;

class BackupInfoEntity implements JsonSerializable, EntityInterface
{
    public const EXPORT_DATE_KEY = 'exportDate';
    public const IMPORT_DATE_KEY = 'importDate';

    private ?string $exportDate = null;

    private ?string $importDate = null;

    public function getExportDate(): ?string
    {
        if (!$this->exportDate) {
            return null;
        }

        return get_date_from_gmt($this->exportDate);
    }

    public function setExportDate(?string $exportDate): self
    {
        $this->exportDate = $exportDate;

        return $this;
    }

    public function getImportDate(): ?string
    {
        if (!$this->importDate) {
            return null;
        }

        return get_date_from_gmt($this->importDate);
    }

    public function setImportDate(?string $importDate): self
    {
        $this->importDate = $importDate;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            self::EXPORT_DATE_KEY => $this->exportDate,
            self::IMPORT_DATE_KEY => $this->importDate,
        ];
    }
}