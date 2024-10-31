<?php

namespace Me_Qr\Services\Packages\Validator\Assert;

use Me_Qr\Services\Packages\Validator\Assert\Constraints\DateTime;
use Me_Qr\Services\Packages\Validator\Assert\Constraints\Length;
use Me_Qr\Services\Packages\Validator\Assert\Constraints\NotBlank;
use Me_Qr\Services\Packages\Validator\Assert\Constraints\NotNull;
use Me_Qr\Services\Packages\Validator\Assert\Constraints\QrFormat;
use Me_Qr\Services\Packages\Validator\Assert\Constraints\Type;

class AssertConfigs
{
    /**
     * Name of the annotation validator
     * Specified above the class property for its validation
     */
    public const ASSERT_ANNOTATION_TITLE = 'MeQrAssert\\';

    /**
     * Name of the option for annotation of the validated class.
     * Has a bool type - true or false.
     * Sets the rule whether to translate all error messages in the validated class.
     * Individual options for each property take precedence over this setting.
     */
    public const ASSERT_TRANSLATE_CLASS_OPTION = 'translate';

    public static function getAssertTypes(): array {
        return [
            Type::getTitle() => Type::class,
            NotNull::getTitle() => NotNull::class,
            NotBlank::getTitle() => NotBlank::class,
            Length::getTitle() => Length::class,
            DateTime::getTitle() => DateTime::class,
            QrFormat::getTitle() => QrFormat::class,
        ];
    }
}
