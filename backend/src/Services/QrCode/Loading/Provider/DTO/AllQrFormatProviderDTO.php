<?php

namespace Me_Qr\Services\QrCode\Loading\Provider\DTO;

use Me_Qr\Services\QrCode\Loading\Provider\QrProviderOptions;

class AllQrFormatProviderDTO
{
    private OneQrFormatProviderDTO $pngQr;
    private OneQrFormatProviderDTO $svgQr;

    public function __construct(
        OneQrFormatProviderDTO $pngQr,
        OneQrFormatProviderDTO $svgQr
    ) {
        $this->pngQr = $pngQr;
        $this->svgQr = $svgQr;
    }

    public function getPngQr(): OneQrFormatProviderDTO
    {
        return $this->pngQr;
    }

    public function setPngQr(OneQrFormatProviderDTO $pngQr): self
    {
        $this->pngQr = $pngQr;

        return $this;
    }

    public function getSvgQr(): OneQrFormatProviderDTO
    {
        return $this->svgQr;
    }

    public function setSvgQr(OneQrFormatProviderDTO $svgQr): self
    {
        $this->svgQr = $svgQr;

        return $this;
    }

	public function toResponseArray(): array
	{
		return [
			QrProviderOptions::PNG_QR_RESPONSE_KEY => $this->getPngQr()->getQrCode(),
			QrProviderOptions::SVG_QR_RESPONSE_KEY => $this->getSvgQr()->getQrCode(),
		];
	}
}
