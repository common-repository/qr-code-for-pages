<?php

namespace Me_Qr\Services\QrCode\Loading\Provider\DTO;

class AllQrFormatProviderDTOBuilder
{
    public static function build(
        OneQrFormatProviderDTO $pngQr,
        OneQrFormatProviderDTO $svgQr
    ): AllQrFormatProviderDTO {
        return new AllQrFormatProviderDTO($pngQr, $svgQr);
    }
}
