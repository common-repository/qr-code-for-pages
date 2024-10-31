<?php

namespace Me_Qr\Services\ErrorHandler;

use DateInterval;
use DateTime;
use DateTimeZone;
use Exception;
use Me_Qr\Entity\Options\UniqueExceptionOption;
use Throwable;

class UniqueExceptionService
{
    private const RECORD_KEY = 'key';
    private const EXPIRATION_KEY = 'exp';

    public function isUnique(Throwable $exception): bool
    {
        $allRecords = $this->clearOldRecords(UniqueExceptionOption::get());
        $uniqueExceptionKey = $this->createUniqueKey($exception);
        if ($this->isExistException($allRecords, $uniqueExceptionKey)) {
            return false;
        }
        $this->saveUniqueException($allRecords, $uniqueExceptionKey);

        return true;
    }

    private function clearOldRecords(array $allRecords): array
    {
        $currentDateTime = gmdate('Y-m-d H:i:s');

        foreach ($allRecords as $key => $record) {
            $recordKey = $record[self::RECORD_KEY] ?? null;
            $expiration = $record[self::EXPIRATION_KEY] ?? null;

            /** @noinspection NotOptimalIfConditionsInspection */
            if (!$recordKey ||
                !$expiration ||
                !DateTime::createFromFormat('Y-m-d H:i:s', $expiration) ||
                $expiration < $currentDateTime
            ) {
                unset($allRecords[$key]);
            }
        }

        return $allRecords;
    }

    private function createUniqueKey(Throwable $exception): string
    {
        return str_replace(
            ['/', '.php'],
            '',
            strrchr($exception->getFile(), '/') . ':' . $exception->getLine()
        );
    }

    private function isExistException(array $allRecords, string $key): bool
    {
        if (empty($allRecords)) {
            return false;
        }

        foreach ($allRecords as $record) {
            if (is_array($record) && in_array($key, $record, true)) {
                return true;
            }
        }
        return false;
    }

    private function saveUniqueException(array $allRecords, string $key): void
    {
        $record = [];
        $record[self::RECORD_KEY] = $key;

        try {
            $expiration = (new DateTime('now', new DateTimeZone('UTC')))->add(new DateInterval('PT30M'));
        } catch (Exception $e) {
            return;
        }
        $record[self::EXPIRATION_KEY] = $expiration->format('Y-m-d H:i:s');

        $allRecords[] = $record;
        UniqueExceptionOption::save($allRecords);
    }

    public function clearExceptionData(): void
    {
        UniqueExceptionOption::save([]);
    }
}