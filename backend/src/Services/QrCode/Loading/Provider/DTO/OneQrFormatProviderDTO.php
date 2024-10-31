<?php

namespace Me_Qr\Services\QrCode\Loading\Provider\DTO;

use Me_Qr\Services\QrCode\Loading\Provider\QrProviderOptions;

class OneQrFormatProviderDTO
{
    private string $qrCode;
    private string $format;

    public function __construct(
        string $qrCode,
        string $format
    ) {
        $this->qrCode = $qrCode;
        $this->format = $format;
    }

    public function getQrCode(): string
    {
        return $this->qrCode;
    }
    
    public function setQrCode(string $qrCode): self
    {
        $this->qrCode = $qrCode;

        return $this;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }

	public function toResponseArray(): array
	{
		return [
			QrProviderOptions::QR_CODE_FORMAT_KEY => $this->getFormat(),
			QrProviderOptions::QR_CODE_RESPONSE_KEY => $this->getQrCode(),
		];
	}
}
