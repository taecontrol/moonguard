<?php

namespace Taecontrol\Larastats\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Taecontrol\Larastats\Contracts\LarastatsUser;

class UserRepository extends ModelRepository
{
    protected static string $contract = LarastatsUser::class;

    protected static string $modelClassConfigKey = 'larastats.user.model';

    public static function all(): Collection
    {
        return self::resolveModelClass()::all();
    }

    public static function resolveModel(): LarastatsUser
    {
        $modelClass = static::resolveModelClass();

        return new $modelClass();
    }
}
