<?php

namespace Taecontrol\Moonguard\Repositories;

use Taecontrol\Moonguard\Contracts\MoonguardExceptionLogGroup;

class ExceptionLogGroupRepository extends ModelRepository
{
    protected static string $contract = MoonguardExceptionLogGroup::class;

    protected static string $modelClassConfigKey = 'moonguard.exceptions.exception_log_group.model';

    public static function isEnabled(): bool
    {
        return config('moonguard.exceptions.enabled');
    }

    public static function findOrFail(string|int $id): MoonguardExceptionLogGroup
    {
        return static::resolveModelClass()::findOrFail($id);
    }

    public static function create(array $attributes = []): MoonguardExceptionLogGroup
    {
        return static::resolveModelClass()::create($attributes);
    }

    public static function resolveModel(): MoonguardExceptionLogGroup
    {
        $modelClass = static::resolveModelClass();

        return new $modelClass();
    }
}
