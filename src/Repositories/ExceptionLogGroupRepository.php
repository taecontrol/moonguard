<?php

namespace Taecontrol\Larastats\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Taecontrol\Larastats\Contracts\LarastatsExceptionLogGroup;
use Taecontrol\Larastats\Models\ExceptionLogGroup;

class ExceptionLogGroupRepository
{
    public static function findOrFail(string|int $id): LarastatsExceptionLogGroup
    {
        return static::resolveModelClass()::findOrFail($id);
    }

    public static function query(): Builder
    {
        return static::resolveModelClass()::query();
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

    public static function resolveModelClass(): string
    {
        return config('larastats.exception_log_group.model') ?? ExceptionLogGroup::class;
    }
}
