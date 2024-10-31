<?php declare(strict_types=1);

namespace Me_Qr\Services\Packages\HttpClient;

class ResponseData
{
    public const DEFAULT_CODE = 200;
    public const DEFAULT_MESSAGE = 'The request was successful';

    private int $code;

    private string $message;

    private array $data;

    public function __construct(
        int $code = self::DEFAULT_CODE,
        ?string $message = self::DEFAULT_MESSAGE,
        array $data = []
    ) {
        $this->code = $code;
        $this->message = $message ?? self::DEFAULT_MESSAGE;
        $this->data = $data;
    }

    public static function create(
        int $code = self::DEFAULT_CODE,
        ?string $message = self::DEFAULT_MESSAGE,
        array $data = []
    ): self {
        return new self($code, $message, $data);
    }

    public function isOk(): bool
    {
        return $this->code >= 200 && $this->code <= 299;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    public function getData(): array
    {
        return $this->data;
    }
}