<?php

namespace Me_Qr\Services\PluginSettings\DTO;

use Me_Qr\Services\Packages\Validator\Assert\Constraints as MeQrAssert;

/**
 * @MeQrAssert(translate="true")
 */
class SettingsPageDTO
{
    /**
     * @MeQrAssert\Type(type="string", message="QR block class must be string type, {{ invalid }} given")
     * @MeQrAssert\Length(
     *     max="100",
     *     message="The QR block class must have a minimum of {{ min }} and a maximum of {{ max }} characters"
     *)
     */
    private $qrBlockClass;

    /**
     * @MeQrAssert\Type(type="string", message="QR image class must be string type, {{ invalid }} given")
     * @MeQrAssert\Length(
     *     max="100"
     *     message="The QR image class must have a minimum of {{ min }} and a maximum of {{ max }} characters"
     *)
     */
    private $qrImgClass;

    /**
     * @MeQrAssert\NotBlank(message="File logging value cannot be empty")
     * @MeQrAssert\Type(type="bool", message="File logging value must be boolean type, {{ invalid }} given")
     */
    private $fileLoggingValue;

    /**
     * @MeQrAssert\NotBlank(message="Telegram logging value cannot be empty")
     * @MeQrAssert\Type(type="bool", message="Telegram logging value must be boolean type, {{ invalid }} given")
     */
    private $tgLoggingValue;

    public function __construct($qrBlockClass, $qrImgClass, $fileLoggingValue, $tgLoggingValue)
    {
        $this->qrBlockClass = $qrBlockClass;
        $this->qrImgClass = $qrImgClass;
        $this->fileLoggingValue = $fileLoggingValue;
        $this->tgLoggingValue = $tgLoggingValue;
    }

    public function getQrBlockClass(): ?string
    {
        return $this->qrBlockClass;
    }

    public function getQrImgClass(): ?string
    {
        return $this->qrImgClass;
    }

    public function getFileLoggingValue(): bool
    {
        return $this->fileLoggingValue;
    }

    public function getTgLoggingValue(): bool
    {
        return $this->tgLoggingValue;
    }
}
