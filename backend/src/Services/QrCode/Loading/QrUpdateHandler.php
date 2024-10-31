<?php

namespace Me_Qr\Services\QrCode\Loading;

use Me_Qr\Services\ErrorHandler\ErrorHandlerService;
use Me_Qr\Services\File\QrFileManager;
use Me_Qr\Services\QrCode\Loading\Provider\QrProvider;
use Throwable;

class QrUpdateHandler
{
    private QrProvider $qrProvider;
    private QrFileManager $qrFileManager;
    private ErrorHandlerService $errorHandlerService;

    public function __construct(
        QrProvider $qrProvider,
        QrFileManager $qrFileManager,
        ErrorHandlerService $errorHandlerService
    ) {
        $this->qrProvider = $qrProvider;
        $this->qrFileManager = $qrFileManager;
        $this->errorHandlerService = $errorHandlerService;
    }

    /**
     * Registers a hook that catches a page permalink change
     * (when renaming a post, or manually changing the permalink),
     * and makes a request to update the qr code
     */
    public function registerPostUpdateHook(): void
    {
        add_action('wp_insert_post_data', function($data, $postArr) {
            $postId = $postArr['ID'] ?? null;
            if (!$postId || !$this->qrFileManager->isQrsExists($postId)) {
                return $data;
            }

            $post = get_post($postId);
            $postName = $post->post_name;
            $newPostName = $postArr['post_name'] ?? null;

            if ($postName !== $newPostName) {
                add_action('save_post', function($postId) {
                    $newPostLink = get_permalink($postId);
                    try {
                        $this->qrProvider->updateAllQrFormatsByLink($postId, $newPostLink);
                    } catch (Throwable $e) {
                        $this->errorHandlerService->handleException($e);
                    }
                });
            }

            return $data;
        }, 10, 2);
    }
}
