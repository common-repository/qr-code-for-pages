<?php

namespace Me_Qr\Services\Loggers\TelegramLog;

use Me_Qr\Services\Loggers\TelegramLog\Format\TgLogErrorFormat;
use Me_Qr\Services\Loggers\TelegramLog\Format\TgLogInfoFormat;
use Me_Qr\Services\Requests\TelegramLogRequest;
use Throwable;

class TelegramLogHandler
{
    private TgLogErrorFormat $errorFormat;
    private TgLogInfoFormat $infoFormat;
    private TelegramLogRequest $telegramLogRequest;

    public function __construct(
        TgLogErrorFormat $errorFormat,
        TgLogInfoFormat $infoFormat,
        TelegramLogRequest $telegramLogRequest
    ) {
        $this->errorFormat = $errorFormat;
        $this->infoFormat = $infoFormat;
        $this->telegramLogRequest = $telegramLogRequest;
    }

    public function error(string $message): void
    {
        $this->telegramLogRequest->sendMessage(
            $this->errorFormat->createByMessage($message)
        );
    }

    public function exception(Throwable $exception): void
    {
        $this->telegramLogRequest->sendMessage(
            $this->errorFormat->createByException($exception)
        );
    }

    public function info(string $message): void
    {
        $this->telegramLogRequest->sendMessage(
            $this->infoFormat->createByMessage($message)
        );
    }
}