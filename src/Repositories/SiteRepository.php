<?php

namespace Taecontrol\Larastats\Repositories;

use Taecontrol\Larastats\Contracts\LarastatsSite;

class SiteRepository extends ModelRepository
{
    protected static string $contract = LarastatsSite::class;

    protected static string $modelClassConfigKey = 'larastats.site.model';

    public static function findOrFail(string|int $id): LarastatsSite
    {
        return static::resolveModelClass()::findOrFail($id);
    }

    public static function resolveModel(): LarastatsSite
    {
        $modelClass = static::resolveModelClass();

        return new $modelClass();
    }
}
