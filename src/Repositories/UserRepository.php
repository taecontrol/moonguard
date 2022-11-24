<?php

namespace Taecontrol\Larastats\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Taecontrol\Larastats\Models\User;

class UserRepository
{
    public static function all(): Collection
    {
        return self::resolveModelClass()::all();
    }

    public static function resolveModelClass(): string
    {
        return config('larastats.user.model') ?? User::class;
    }
}
