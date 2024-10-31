<?php

namespace Me_Qr\Services\QrCode\Loading\Request\DTO;

use Me_Qr\Services\Packages\Validator\Assert\Constraints as MeQrAssert;

class AllQrFormatRequestDTO extends AbstractQrRequestDTO
{
    /**
     * @var mixed
     *
     * @MeQrAssert\NotBlank(message="QR code with png format not received")
     * @MeQrAssert\Type(type="string", message="The QR code in png format must be of string type, {{ invalid }} given")
     */
    private $pngQr;

    /**
     * @var mixed
     *
     * @MeQrAssert\NotBlank(message="QR code with svg format not received")
     * @MeQrAssert\Type(type="string", message="The QR code in svg format must be of string type, {{ invalid }} given")
     */
    private $svgQr;

    public function __construct(
	    $qrCodeId,
        $pngQr,
        $svgQr
    ) {
		parent::__construct($qrCodeId);

        $this->pngQr = $pngQr;
        $this->svgQr = $svgQr;
    }

    public function getPngQr(): string
    {
        return $this->pngQr;
    }

    public function getSvgQr(): string
    {
        return $this->svgQr;
    }
}
