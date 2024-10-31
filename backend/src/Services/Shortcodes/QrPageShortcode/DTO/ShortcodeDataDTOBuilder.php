<?php

namespace Me_Qr\Services\Shortcodes\QrPageShortcode\DTO;

use Me_Qr\Services\Shortcodes\QrPageShortcode\QrPageShortcodeOptions;

class ShortcodeDataDTOBuilder
{
    public static function build($postId, $format, $qrBlockClass, $qrImgClass): ShortcodeDataDTO
    {
        return new ShortcodeDataDTO($postId, $format, $qrBlockClass, $qrImgClass);
    }

    public static function buildByOptionArray(array $options): ShortcodeDataDTO
    {
        return self::build(
            $options[QrPageShortcodeOptions::POST_ID_OPTION] ?? null,
            $options[QrPageShortcodeOptions::QR_FORMAT_OPTION] ?? null,
            $options[QrPageShortcodeOptions::QR_BLOCK_CLASS_OPTION] ?? null,
            $options[QrPageShortcodeOptions::QR_IMG_CLASS_OPTION] ?? null,
        );
    }
}
