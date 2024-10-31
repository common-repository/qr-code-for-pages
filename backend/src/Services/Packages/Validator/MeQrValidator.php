<?php

namespace Me_Qr\Services\Packages\Validator;

use Me_Qr\Services\Packages\Validator\Assert\AssertService;

class MeQrValidator
{
    private AssertService $assertService;

    public function __construct(
        AssertService $assertService
    ) {
        $this->assertService = $assertService;
    }

    public function validate($case): ValidationExceptionList
    {
        if (is_object($case)) {
            return $this->assertService->validate($case);
        }

        return new ValidationExceptionList();
    }
}
