<?php

namespace Taecontrol\Larastats\Repositories;

use Taecontrol\Larastats\Contracts\LarastatsExceptionLog;

class ExceptionLogRepository extends ModelRepository
{
    protected static string $contract = LarastatsExceptionLog::class;

    protected static string $modelClassConfigKey = 'larastats.exceptions.exception_log.model';

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
}
