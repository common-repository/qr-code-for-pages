<?php

namespace Me_Qr\Services\Packages\Response;

class SystemErrorResponse extends AbstractResponse
{
    private string $errorMessage;

    public function __construct(
        string $errorMessage = 'Internal system error. Contact plugin support',
        array $contentData = [],
        array $headers = []
    ) {
        $this->errorMessage = esc_html__($errorMessage, 'me-qr');

        parent::__construct(false, 500, $contentData, $this->parse(), $headers);
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