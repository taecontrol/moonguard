<?php

namespace Taecontrol\Larastats\Repositories;

use Taecontrol\Larastats\Contracts\LarastatsUptimeCheck;
use Taecontrol\Larastats\Models\UptimeCheck;

class UptimeCheckRepository
{
    public static function isEnabled(): bool
    {
        return config('larastats.uptime_check.enabled');
    }

    public static function resolveModel(): LarastatsUptimeCheck
    {
        $modelClass = static::resolveModelClass();

        return new $modelClass();
    }

    public static function resolveModelClass(): string
    {
        return config('larastats.uptime_check.model') ?? UptimeCheck::class;
    }
}
