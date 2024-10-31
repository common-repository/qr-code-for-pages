<?php

namespace Me_Qr\Services\Loggers\TelegramLog\Format;

class TgLogInfoFormat
{
    public function createByMessage($message): string
    {
        $text = "\xE2\x9D\x95 Уведомление \n";
        $text .= "Домен: " . get_site_url() . " \n";
        $text .=
            "Полный URL: " .
            ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] .
            sanitize_url($_SERVER['REQUEST_URI']) . "\n"
        ;
        $text .= "\n";
        $text .= "Содержание уведомления: $message \n";

        return $text;
    }
}
