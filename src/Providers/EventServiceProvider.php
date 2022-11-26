<?php

namespace Taecontrol\Larastats\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    public function listens()
    {
        return config('larastats.events.listen');
    }
}
