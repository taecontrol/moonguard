<?php

namespace Taecontrol\MoonGuard\Repositories;

use Taecontrol\MoonGuard\Contracts\MoonGuardExceptionLogGroup;

class ExceptionLogGroupRepository extends ModelRepository
{
    protected static string $contract = MoonGuardExceptionLogGroup::class;

    protected static string $modelClassConfigKey = 'moonguard.exceptions.exception_log_group.model';

    public static function isEnabled(): bool
    {
        return config('moonguard.exceptions.enabled');
    }

    public static function findOrFail(string|int $id): MoonGuardExceptionLogGroup
    {
        return static::resolveModelClass()::findOrFail($id);
    }

    public static function create(array $attributes = []): MoonGuardExceptionLogGroup
    {
        return static::resolveModelClass()::create($attributes);
    }

    public static function resolveModel(): MoonGuardExceptionLogGroup
    {
        $modelClass = static::resolveModelClass();

        return new $modelClass();
    }
}
