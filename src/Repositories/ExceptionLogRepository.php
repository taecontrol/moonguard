<?php

namespace Taecontrol\Moonguard\Repositories;

use Taecontrol\Moonguard\Contracts\MoonguardExceptionLog;

class ExceptionLogRepository extends ModelRepository
{
    protected static string $contract = MoonguardExceptionLog::class;

    protected static string $modelClassConfigKey = 'moonguard.exceptions.exception_log.model';

    public static function isEnabled(): bool
    {
        return config('moonguard.exceptions.enabled');
    }

    public static function create(array $attributes = []): MoonguardExceptionLog
    {
        return static::resolveModelClass()::create($attributes);
    }

    public static function resolveModel(): MoonguardExceptionLog
    {
        $modelClass = static::resolveModelClass();

        return new $modelClass();
    }
}
