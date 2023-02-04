<?php

namespace Taecontrol\MoonGuard\Repositories;

use Taecontrol\MoonGuard\Contracts\MoonGuardExceptionLog;

class ExceptionLogRepository extends ModelRepository
{
    protected static string $contract = MoonGuardExceptionLog::class;

    protected static string $modelClassConfigKey = 'moonguard.exceptions.exception_log.model';

    public static function isEnabled(): bool
    {
        return config('moonguard.exceptions.enabled');
    }

    public static function create(array $attributes = []): MoonGuardExceptionLog
    {
        return static::resolveModelClass()::create($attributes);
    }

    public static function resolveModel(): MoonGuardExceptionLog
    {
        $modelClass = static::resolveModelClass();

        return new $modelClass();
    }
}
