<?php

namespace Me_Qr\Services\QrCode\Loading\Request\DTO;

use Me_Qr\Services\Packages\Validator\Assert\Constraints as MeQrAssert;

class OneQrFormatRequestDTO extends AbstractQrRequestDTO
{
    /**
     * @var mixed
     *
     * @MeQrAssert\NotBlank(message="QR code not received")
     * @MeQrAssert\Type(type="string", message="QR code must be of string type, {{ invalid }} given")
     */
    private $qrCode;

    public function __construct($qrCodeId, $qrCode)
    {
	    parent::__construct($qrCodeId);

        $this->qrCode = $qrCode;
    }

	public function getQrCode(): string
	{
		return $this->qrCode;
	}
}
