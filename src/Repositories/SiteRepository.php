<?php

namespace Taecontrol\MoonGuard\Repositories;

use Taecontrol\MoonGuard\Contracts\MoonGuardSite;

class SiteRepository extends ModelRepository
{
    protected static string $contract = MoonGuardSite::class;

    protected static string $modelClassConfigKey = 'moonguard.site.model';

    public static function findOrFail(string|int $id): MoonGuardSite
    {
        return static::resolveModelClass()::findOrFail($id);
    }

    public static function resolveModel(): MoonGuardSite
    {
        $modelClass = static::resolveModelClass();

        return new $modelClass();
    }
}
