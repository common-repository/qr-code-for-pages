<?php

namespace Me_Qr\Services\ErrorHandler;

use Throwable;

class ExceptionTraceService
{
    public function getTraceStringByException(Throwable $exception): string
    {
        $traceString = "След ошибки: \n";
        $numbering = 1;

        $firstFile = $this->trimPluginFileString($exception->getFile());
        $firstLine = $exception->getLine();
        $traceString .= "#$numbering $firstFile($firstLine) \n";
        $numbering++;

        foreach ($exception->getTrace() as $trace) {
            $file = $this->trimPluginFileString($trace['file'] ?? null);
            if (!$file) {
                continue;
            }
            $traceString .= "#$numbering $file";

            $traceLine = $trace['line'] ?? null;
            if ($traceLine) {
                $traceString .= "($traceLine)";
            }

            $function = $trace['function'] ?? null;
            if ($function) {
                $traceString .= ": $function()";
            }

            $traceString .= "\n";

            $numbering++;
        }

        return $traceString;
    }

    private function trimPluginFileString(?string $file): ?string
    {
        $pluginDir = strstr(plugin_basename(__DIR__), '/', true);
        if (!$pluginDir || !$file || !str_contains($file, $pluginDir)) {
            return null;
        }

        return strstr($file, $pluginDir . '/');
    }
}
