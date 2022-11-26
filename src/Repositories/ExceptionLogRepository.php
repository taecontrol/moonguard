<?php

namespace Taecontrol\Larastats\Repositories;

use Taecontrol\Larastats\Contracts\LarastatsExceptionLog;
use Taecontrol\Larastats\Models\ExceptionLog;

class ExceptionLogRepository
{
    public static function isEnabled(): bool
    {
        return config('larastats.exceptions.enabled');
    }

    public static function resolveModel(): LarastatsExceptionLog
    {
        $modelClass = static::resolveModelClass();

        return new $modelClass();
    }

    public static function resolveModelClass(): string
    {
        return config('larastats.exceptions.exception_log.model') ?? ExceptionLog::class;
    }
}
