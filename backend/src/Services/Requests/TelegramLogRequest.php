<?php declare(strict_types=1);

namespace Me_Qr\Services\Requests;

use Me_Qr\Repository\PluginSettingsRepository;
use Me_Qr\Services\Packages\HttpClient\AbstractRequest;
use Me_Qr\Services\Url\DevService;

class TelegramLogRequest extends AbstractRequest
{
    public const TG_BOT_API_DOMAIN = 'https://api.telegram.org/bot';

    public function sendMessage(string $message): bool
    {
        if (!$this->checkAccess()) {
            return false;
        }

        $responseData = $this->createPostRequest($this->getBaseUri() . '/sendMessage', [
            'chat_id' => base64_decode(ME_QR_TELEGRAM_CHAT_ID),
            'text' => $message,
            'parse_mode' => 'html',
            'disable_web_page_preview' => true,
        ]);

        return $responseData->isOk();
    }

    private function checkAccess(): bool
    {
        if (defined('ME_QR_ENABLE_TG_LOG_PARAM') && ME_QR_ENABLE_TG_LOG_PARAM !== null) {
            if (ME_QR_ENABLE_TG_LOG_PARAM === true) {
                return true;
            }
            if (ME_QR_ENABLE_TG_LOG_PARAM === false) {
                return false;
            }
        }

        if (DevService::isDevMode()) {
            return false;
        }

        $pluginSettings = PluginSettingsRepository::findEntity();
        if ($pluginSettings) {
            return $pluginSettings->isTgLogging();
        }

        return ME_QR_IS_SENDING_TG_LOGS_DEFAULT;
    }

    private function getBaseUri(): string
    {
        return self::TG_BOT_API_DOMAIN . base64_decode(ME_QR_TELEGRAM_BOT_TOKEN);
    }
}
