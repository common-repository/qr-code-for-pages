<?php

namespace Me_Qr\Services\Packages\Response;

class BadResponse extends AbstractResponse
{
    private string $errorMessage;

    public function __construct(
        string $errorMessage = 'Internal data error. Carefully check the data or contact the plugin support',
        array $contentData = [],
        array $headers = []
    ) {
        $this->errorMessage = esc_html__($errorMessage, 'me-qr');

        parent::__construct(false, 400, $contentData, $this->parse(), $headers);
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    private function parse(): array
    {
        return [
            'message' => $this->errorMessage,
        ];
    }
}