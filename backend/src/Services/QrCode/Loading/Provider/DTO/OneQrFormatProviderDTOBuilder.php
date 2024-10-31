<?php

namespace Me_Qr\Services\QrCode\Loading\Provider\DTO;

class OneQrFormatProviderDTOBuilder
{
    public static function build(
        string $qrCode,
        string $format
    ): OneQrFormatProviderDTO {
        return new OneQrFormatProviderDTO($qrCode, $format);
    }
}
