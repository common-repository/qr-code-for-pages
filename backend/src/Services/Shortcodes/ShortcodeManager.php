<?php

namespace Me_Qr\Services\Shortcodes;

use Me_Qr\Services\Shortcodes\QrPageShortcode\QrPageShortcodeHandler;

class ShortcodeManager
{
    private QrPageShortcodeHandler $qrPageShortcodeHandler;

    public function __construct(
        QrPageShortcodeHandler $qrPageShortcodeHandler
    ) {
        $this->qrPageShortcodeHandler = $qrPageShortcodeHandler;
    }

    public function registerAll(): void
    {
        add_shortcode('me_qr_block', [$this->qrPageShortcodeHandler, 'register']);
    }
}
