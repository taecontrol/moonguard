<?php

namespace Taecontrol\Moonguard\Repositories;

use Taecontrol\Moonguard\Contracts\MoonguardUptimeCheck;

class UptimeCheckRepository extends ModelRepository
{
    protected static string $contract = MoonguardUptimeCheck::class;

    protected static string $modelClassConfigKey = 'moonguard.uptime_check.model';

    public static function isEnabled(): bool
    {
        return config('moonguard.uptime_check.enabled');
    }

    public static function resolveModel(): MoonguardUptimeCheck
    {
        $modelClass = static::resolveModelClass();

        return new $modelClass();
    }
}
