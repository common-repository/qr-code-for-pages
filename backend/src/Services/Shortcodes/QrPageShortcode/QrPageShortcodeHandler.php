<?php

namespace Me_Qr\Services\Shortcodes\QrPageShortcode;

use Me_Qr\Exceptions\InternalDataException;
use Me_Qr\Repository\PluginSettingsRepository;
use Me_Qr\Services\ErrorHandler\ErrorHandlerService;
use Me_Qr\Services\Packages\Template\TemplateManager;
use Me_Qr\Services\Packages\Validator\Exceptions\ValidationException;
use Me_Qr\Services\Packages\Validator\MeQrValidator;
use Me_Qr\Services\QrCode\Loading\Provider\QrProvider;
use Me_Qr\Services\Shortcodes\QrPageShortcode\DTO\ShortcodeDataDTOBuilder;
use Throwable;

class QrPageShortcodeHandler
{
    private QrProvider $qrProvider;
    private MeQrValidator $meQrValidator;
    private ErrorHandlerService $errorHandlerService;
    private TemplateManager $templateManager;

    public function __construct(
        QrProvider $qrProvider,
        MeQrValidator $meQrValidator,
        ErrorHandlerService $errorHandlerService,
        TemplateManager $templateManager
    ) {
        $this->qrProvider = $qrProvider;
        $this->meQrValidator = $meQrValidator;
        $this->errorHandlerService = $errorHandlerService;
        $this->templateManager = $templateManager;
    }

    public function register($attrs): ?string
    {
        try {
            $shortcodeDTO = ShortcodeDataDTOBuilder::buildByOptionArray($attrs);
            $exceptions = $this->meQrValidator->validate($shortcodeDTO);
            if ($exceptions->isExceptions()) {
                throw new ValidationException($exceptions->getExceptionString());
            }

            $pluginSettings = PluginSettingsRepository::findEntity();
            if ($pluginSettings) {
                $shortcodeDTO->addQrBlockClass($pluginSettings->getQrBlockClass());
                $shortcodeDTO->addQrImgClass($pluginSettings->getQrImgClass());
            }

            $postLink = get_permalink($shortcodeDTO->getPostId());
            if (!$postLink) {
                throw new InternalDataException('No post found for the specified post id');
            }
            $qrProviderDTO = $this->qrProvider->getOneQrFormat(
                $shortcodeDTO->getPostId(),
                $postLink,
                $shortcodeDTO->getFormat()
            );
        } catch (InternalDataException $e) {
            $this->errorHandlerService->writeExceptionToLog($e);
            return null;
        } catch (Throwable $e) {
            $this->errorHandlerService->handleException($e);
            return null;
        }

        return $this->templateManager->getIncludeString('front/me-qr-shortcode-qr-template', [
            'shortcodeDTO' => $shortcodeDTO,
            'qrCodeDTO' => $qrProviderDTO,
        ]);
    }
}