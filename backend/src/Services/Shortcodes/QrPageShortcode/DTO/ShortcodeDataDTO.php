<?php

namespace Me_Qr\Services\Shortcodes\QrPageShortcode\DTO;

use Me_Qr\Services\Packages\Validator\Assert\Constraints as MeQrAssert;

class ShortcodeDataDTO
{
    /**
     * @MeQrAssert\NotBlank(message="Post id cannot be empty")
     * @MeQrAssert\Type(type="numeric", message="Post id for shortcode must be of numeric type, {{ invalid }} given")
     */
    private $postId;

    /**
     * @MeQrAssert\NotBlank(message="QR format for shortcode cannot be empty")
     * @MeQrAssert\QrFormat()
     */
    private $format;

    /**
     * @MeQrAssert\Type(type="string", message="QR block class for shortcode must be a string type, {{ invalid }} given")
     */
    private $qrBlockClass;

    /**
     * @MeQrAssert\Type(type="string", message="QR image class for shortcode must be a string type, {{ invalid }} given")
     */
    private $qrImgClass;

    public function __construct($postId, $format, $qrBlockClass, $qrImgClass)
    {
        $this->postId = $postId;
        $this->format = $format;
        $this->qrBlockClass = $qrBlockClass;
        $this->qrImgClass = $qrImgClass;
    }

    public function getPostId(): int
    {
        return $this->postId;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function getQrBlockClass(): ?string
    {
        return $this->qrBlockClass;
    }

    public function addQrBlockClass(?string $value): self
    {
        if (!$value) {
            return $this;
        }
        $this->qrBlockClass = $value;

        return $this;
    }

    public function getQrImgClass(): ?string
    {
        return $this->qrImgClass;
    }

    public function addQrImgClass(?string $value): self
    {
        if (!$value) {
            return $this;
        }
        $this->qrImgClass = $value;

        return $this;
    }
}
