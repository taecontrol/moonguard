<?php

namespace Taecontrol\Moonguard\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Taecontrol\Moonguard\Contracts\MoonguardUser;

class UserRepository extends ModelRepository
{
    protected static string $contract = MoonguardUser::class;

    protected static string $modelClassConfigKey = 'moonguard.user.model';

    public static function all(): Collection
    {
        return self::resolveModelClass()::all();
    }

    public static function resolveModel(): MoonguardUser
    {
        $modelClass = static::resolveModelClass();

        return new $modelClass();
    }
}
