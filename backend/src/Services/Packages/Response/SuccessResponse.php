<?php

namespace Me_Qr\Services\Packages\Response;

class SuccessResponse extends AbstractResponse
{
    public function __construct(array $contentData = [], array $systemData = [], array $headers = [])
    {
        parent::__construct(true, 200, $contentData, $systemData, $headers);
    }
}