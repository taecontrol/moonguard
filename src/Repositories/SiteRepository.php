<?php

namespace Taecontrol\Larastats\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Taecontrol\Larastats\Contracts\LarastatsSite;
use Taecontrol\Larastats\Models\Site;

class SiteRepository
{
    public static function query(): Builder
    {
        return static::resolveModelClass()::query();
    }

    public static function resolveModel(): LarastatsSite
    {
        $modelClass = static::resolveModelClass();

        return new $modelClass();
    }

    public static function resolveModelClass(): string
    {
        return config('larastats.site.model') ?? Site::class;
    }
}
