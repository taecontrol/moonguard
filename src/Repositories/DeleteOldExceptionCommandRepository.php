<?php

namespace Taecontrol\MoonGuard\Repositories;

use Taecontrol\MoonGuard\Models\ExceptionLog;

class DeleteOldExceptionCommandRepository
{
    protected static string $modelClassConfigKey = 'moonguard.exceptions.exception_log.model';

    public static function isEnabled(): bool
    {
        return config('moonguard.exception_deletion.enabled');
    }

    public static function getExceptionAge(): int
    {
        return config('moonguard.exception_deletion.delete_exceptions_older_than_minutes');
    }

    public static function deleteOldExceptions(int $time): void
    {
        $exceptions = ExceptionLog::where('thrown_at', '<', now()->subMinutes($time))->get();
        \Log::info('Found ' . $exceptions->count() . ' exceptions to delete');
        \Log::info('Deleting exceptions older than ' . now()->subMinutes($time));
        $exceptions->each(function ($exception) {
            $exception->delete();
        });
    }

}
