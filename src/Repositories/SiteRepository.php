<?php

namespace Taecontrol\Moonguard\Repositories;

use Taecontrol\Moonguard\Contracts\MoonguardSite;

class SiteRepository extends ModelRepository
{
    protected static string $contract = MoonguardSite::class;

    protected static string $modelClassConfigKey = 'moonguard.site.model';

    public static function findOrFail(string|int $id): MoonguardSite
    {
        return static::resolveModelClass()::findOrFail($id);
    }

    public static function resolveModel(): MoonguardSite
    {
        $modelClass = static::resolveModelClass();

        return new $modelClass();
    }
}
