<?php

namespace Taecontrol\Larastats\Repositories;

use Taecontrol\Larastats\Contracts\LarastatsExceptionLogGroup;

class ExceptionLogGroupRepository extends ModelRepository
{
    protected static string $contract = LarastatsExceptionLogGroup::class;

    protected static string $modelClassConfigKey = 'larastats.exceptions.exception_log_group.model';

    public static function isEnabled(): bool
    {
        return config('larastats.exceptions.enabled');
    }

    public static function findOrFail(string|int $id): LarastatsExceptionLogGroup
    {
        return static::resolveModelClass()::findOrFail($id);
    }

    public static function create(array $attributes = []): LarastatsExceptionLogGroup
    {
        return static::resolveModelClass()::create($attributes);
    }

    public static function resolveModel(): LarastatsExceptionLogGroup
    {
        $modelClass = static::resolveModelClass();

        return new $modelClass();
    }
}
