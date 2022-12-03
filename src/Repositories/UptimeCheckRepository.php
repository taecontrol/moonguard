<?php

namespace Taecontrol\Larastats\Repositories;

use Taecontrol\Larastats\Contracts\LarastatsUptimeCheck;

class UptimeCheckRepository extends ModelRepository
{
    protected static string $contract = LarastatsUptimeCheck::class;

    protected static string $modelClassConfigKey = 'larastats.uptime_check.model';

    public static function isEnabled(): bool
    {
        return config('larastats.uptime_check.enabled');
    }

    public static function resolveModel(): LarastatsUptimeCheck
    {
        $modelClass = static::resolveModelClass();

        return new $modelClass();
    }
}
