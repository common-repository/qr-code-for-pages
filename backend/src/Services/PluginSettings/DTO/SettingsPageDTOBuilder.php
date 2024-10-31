<?php

namespace Me_Qr\Services\PluginSettings\DTO;

use Me_Qr\Services\Packages\Validator\Exceptions\ValidationException;
use Me_Qr\Services\Packages\Validator\MeQrValidator;
use Me_Qr\Services\PluginSettings\PluginSettingsOptions;

class SettingsPageDTOBuilder
{
    private MeQrValidator $meQrValidator;

    public function __construct(MeQrValidator $meQrValidator)
    {
        $this->meQrValidator = $meQrValidator;
    }

    /**
     * @throws ValidationException
     */
    public function build(
        $qrBlockClass,
        $qrImgClass,
        $fileLoggingValue,
        $tgLoggingValue
    ): SettingsPageDTO {
        $settingsPageDto = new SettingsPageDTO(
            $qrBlockClass,
            $qrImgClass,
            $fileLoggingValue,
            $tgLoggingValue
        );

        $exceptions = $this->meQrValidator->validate($settingsPageDto);
        if ($exceptions->isExceptions()) {
            throw new ValidationException($exceptions->getExceptionString(true));
        }

        return $settingsPageDto;
    }

    /**
     * @throws ValidationException
     */
    public function buildByRequestDate(array $date): SettingsPageDTO
    {
        return $this->build(
            $date[PluginSettingsOptions::QR_BLOCK_CLASS_OPTION] ?? null,
            $date[PluginSettingsOptions::QR_IMG_CLASS_OPTION] ?? null,
            $date[PluginSettingsOptions::FILE_LOGGING_OPTION] ?? null,
            $date[PluginSettingsOptions::TG_LOGGING_OPTION] ?? null,
        );
    }
}
