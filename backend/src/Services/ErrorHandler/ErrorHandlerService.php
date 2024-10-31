<?php

namespace Me_Qr\Services\ErrorHandler;

use Me_Qr\Services\AdminPages\AdminNotification;
use Me_Qr\Services\Loggers\TelegramLog\TelegramLogHandler;
use Me_Qr\Services\Loggers\FileLog\FileLogHandler;
use Throwable;

class ErrorHandlerService
{
    private TelegramLogHandler $telegramLogHandler;
    private UniqueExceptionService $uniqueExceptionService;
    private FileLogHandler $fileLogHandler;

    public function __construct(
        TelegramLogHandler $telegramLogHandler,
        UniqueExceptionService $uniqueExceptionService,
        FileLogHandler $fileLogHandler
    ) {
        $this->telegramLogHandler = $telegramLogHandler;
        $this->uniqueExceptionService = $uniqueExceptionService;
        $this->fileLogHandler = $fileLogHandler;
    }

    public function handleException(
        Throwable $exception,
        bool $isWriteLogs = true,
        bool $isShowAdmin = true,
        bool $isSendToTgLog = true
    ): void {
        if ($isWriteLogs) {
            $this->writeExceptionToLog($exception);
        }
        if ($isShowAdmin) {
            AdminNotification::showError($exception->getMessage());
        }
        if ($isSendToTgLog) {
            $this->sendExceptionToTelegramLog($exception);
        }
    }

    public function writeExceptionToLog(Throwable $exception): void
    {
        $this->fileLogHandler->exception($exception);
    }

    public function writeErrorToLog(string $message): void
    {
        $this->fileLogHandler->error($message);
    }

    public function sendExceptionToTelegramLog(Throwable $exception): void
    {
        if ($this->uniqueExceptionService->isUnique($exception)) {
            $this->telegramLogHandler->exception($exception);
        }
    }
}
