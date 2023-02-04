<?php

namespace Taecontrol\MoonGuard\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    public function listens()
    {
        return config('moonguard.events.listen');
    }
}
