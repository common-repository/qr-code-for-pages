<?php

namespace Me_Qr\Services\QrCode\Loading\Provider;

interface QrProviderOptions
{
    public const QR_CODE_RESPONSE_KEY = 'qr_code';
    public const QR_CODE_FORMAT_KEY = 'qr_format';

    public const PNG_QR_RESPONSE_KEY = 'qr_png';
    public const SVG_QR_RESPONSE_KEY = 'qr_svg';
}