<?php

namespace Me_Qr\Entity;

use JsonSerializable;
use Me_Qr\Services\Packages\Validator\Assert\Constraints as MeQrAssert;

/**
 * @MeQrAssert(translate="true")
 */
class PluginSettingsEntity implements JsonSerializable, EntityInterface
{
    public const QR_BLOCK_CLASS_KEY = 'qrBlockClass';
    public const QR_IMG_CLASS_KEY = 'qrImgClass';
    public const FILE_LOGGING_KEY = 'isFileLogging';
    public const TG_LOGGING_KEY = 'isTgLogging';

    private ?string $qrBlockClass;

    private ?string $qrImgClass;

    private bool $isFileLogging;

    private bool $isTgLogging;

    public function getQrBlockClass(): ?string
    {
        return $this->qrBlockClass;
    }

    public function setQrBlockClass(?string $qrBlockClass): self
    {
        $this->qrBlockClass = $qrBlockClass;

        return $this;
    }

    public function getQrImgClass(): ?string
    {
        return $this->qrImgClass;
    }

    public function setQrImgClass(?string $qrImgClass): self
    {
        $this->qrImgClass = $qrImgClass;

        return $this;
    }

    public function isFileLogging(): bool
    {
        return $this->isFileLogging;
    }

    public function setIsFileLogging(bool $isFileLogging): self
    {
        $this->isFileLogging = $isFileLogging;

        return $this;
    }

    public function isTgLogging(): bool
    {
        return $this->isTgLogging;
    }

    public function setIsTgLogging(bool $isTgLogging): self
    {
        $this->isTgLogging = $isTgLogging;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            self::QR_BLOCK_CLASS_KEY => $this->qrBlockClass,
            self::QR_IMG_CLASS_KEY => $this->qrImgClass,
            self::FILE_LOGGING_KEY => $this->isFileLogging,
            self::TG_LOGGING_KEY => $this->isTgLogging,
        ];
    }
}