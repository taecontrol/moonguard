<?php

namespace Taecontrol\MoonGuard\Repositories;

use Taecontrol\MoonGuard\Contracts\MoonGuardUptimeCheck;

class UptimeCheckRepository extends ModelRepository
{
    protected static string $contract = MoonGuardUptimeCheck::class;

    protected static string $modelClassConfigKey = 'moonguard.uptime_check.model';

    public static function isEnabled(): bool
    {
        return config('moonguard.uptime_check.enabled');
    }

    public static function resolveModel(): MoonGuardUptimeCheck
    {
        $modelClass = static::resolveModelClass();

        return new $modelClass();
    }
}
