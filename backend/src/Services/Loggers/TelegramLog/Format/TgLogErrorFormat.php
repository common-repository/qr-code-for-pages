<?php

namespace Me_Qr\Services\Loggers\TelegramLog\Format;

use Me_Qr\Services\ErrorHandler\ExceptionTraceService;
use Throwable;

class TgLogErrorFormat
{
    private ExceptionTraceService $exceptionTraceService;

    public function __construct(
        ExceptionTraceService $exceptionTraceService
    ) {
        $this->exceptionTraceService = $exceptionTraceService;
    }

    public function createByMessage($message, array $context = null): string
    {
        $text = "\xE2\x9D\x97 Ошибка плагина \n";
        $text .= "Домен: " . get_site_url() . " \n";
        $text .=
            "Полный URL: " .
            ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] .
            sanitize_url($_SERVER['REQUEST_URI']) . "\n"
        ;
        $text .= "\n";
        $text .= "Сообщение:\n";
        $text .= "$message \n\n";

        if ($context) {
            $text .= "Конекст:\n";
            $text .= json_encode($context) ?? "Failed to encode context array";
            $text .= "\n";
        }

        return $text;
    }

    public function createByException(Throwable $exception): string
    {
        if (method_exists($exception, 'getContext')) {
            $context = $exception->getContext();
        }

        $text = $this->createByMessage($exception->getMessage(), $context ?? null);
        $text .= "\n";
        $text .= $this->exceptionTraceService->getTraceStringByException($exception);

        return $text;
    }
}
