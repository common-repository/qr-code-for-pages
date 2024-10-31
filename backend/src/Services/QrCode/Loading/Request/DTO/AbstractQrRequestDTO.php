<?php

namespace Me_Qr\Services\QrCode\Loading\Request\DTO;

use Me_Qr\Services\Packages\Validator\Assert\Constraints as MeQrAssert;

abstract class AbstractQrRequestDTO
{
    /**
     * @var mixed
     *
     * @MeQrAssert\NotBlank(message="QR code id code not received")
     * @MeQrAssert\Type(type="int", message="QR code id must be of string type, {{ invalid }} given")
     */
    private $qrCodeId;

    public function __construct($qrCodeId) {
		$this->qrCodeId = $qrCodeId;
    }

	public function getQrCodeId(): int
	{
		return $this->qrCodeId;
	}
}
