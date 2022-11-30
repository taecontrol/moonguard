<?php

namespace Taecontrol\Larastats\Repositories;

use Taecontrol\Larastats\Models\ExceptionLog;
use Taecontrol\Larastats\Contracts\LarastatsExceptionLog;

class ExceptionLogRepository
{
    public static function isEnabled(): bool
    {
        return config('larastats.exceptions.enabled');
    }

    public static function create(array $attributes = []): LarastatsExceptionLog
    {
        return static::resolveModelClass()::create($attributes);
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
