<?php

namespace Me_Qr\Core\Hooks;

use Me_Qr\Services\ErrorHandler\UniqueExceptionService;

class PluginDeactivateInitializer
{
    private UniqueExceptionService $recurringErrorFuse;

    public function __construct(
        UniqueExceptionService $recurringErrorFuse
    ) {
        $this->recurringErrorFuse = $recurringErrorFuse;
    }

    public function handle(): void
    {
        // Actions during plugin deactivation

        $this->recurringErrorFuse->clearExceptionData();
    }
}
