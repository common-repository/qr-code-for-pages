<?php

namespace Me_Qr\Services\Loggers\FileLog;

use Me_Qr\Services\Loggers\FileLog\Format\FileLogErrorFormat;
use Me_Qr\Services\Loggers\FileLog\Format\FileLogInfoFormat;
use Throwable;

class FileLogHandler
{
    private FileLogService $fileLogService;
    private FileLogErrorFormat $errorFormat;
    private FileLogInfoFormat $infoFormat;

    public function __construct(
        FileLogService $fileLogService,
        FileLogErrorFormat $errorFormat,
        FileLogInfoFormat $infoFormat
    ) {
        $this->fileLogService = $fileLogService;
        $this->errorFormat = $errorFormat;
        $this->infoFormat = $infoFormat;
    }

    public function error(string $message): void
    {
        $this->fileLogService->writeToLog(
            $this->errorFormat->createByMessage($message)
        );
    }

    public function exception(Throwable $exception): void
    {
        $this->fileLogService->writeToLog(
            $this->errorFormat->createByException($exception)
        );
    }

    public function info(string $message): void
    {
        $this->fileLogService->writeToLog(
            $this->infoFormat->createByMessage($message)
        );
    }
}