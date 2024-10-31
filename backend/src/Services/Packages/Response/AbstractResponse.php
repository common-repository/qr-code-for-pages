<?php

namespace Me_Qr\Services\Packages\Response;

use WP_REST_Response;

abstract class AbstractResponse extends WP_REST_Response
{
    protected bool $isOk;

    protected int $code;

    protected array $contentData;

    protected array $systemData;

    public function __construct(
        bool $isOk = true,
        int $code = 200,
        array $contentData = [],
        array $systemData = [],
        array $headers = []
    ) {
        $this->isOk = $isOk;
        $this->code = $code;
        $this->systemData = $systemData;
        $this->contentData = $contentData;

        parent::__construct($this->parse(), $this->code, $headers);
    }

    public function isOk(): bool
    {
        return $this->isOk;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    private function parse(): array
    {
        $mainData = [
            'ok' => $this->isOk,
            'code' => $this->code,
        ];

        $mainData = array_merge($mainData, $this->systemData);
        $mainData['data'] = $this->contentData;

        return $mainData;
    }
}