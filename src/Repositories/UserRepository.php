<?php

namespace Taecontrol\Larastats\Repositories;

use Taecontrol\Larastats\Models\User;
use Illuminate\Database\Eloquent\Collection;

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
