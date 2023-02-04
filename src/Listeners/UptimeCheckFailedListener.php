<?php

namespace Taecontrol\MoonGuard\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Repositories\UserRepository;
use Taecontrol\MoonGuard\Events\UptimeCheckFailedEvent;
use Taecontrol\MoonGuard\Notifications\UptimeCheckFailedNotification;

class UptimeCheckFailedListener
{
    public function handle(UptimeCheckFailedEvent $event): void
    {
        Notification::send(
            UserRepository::all(),
            new UptimeCheckFailedNotification($event->uptimeCheck, $event->downtimePeriod)
        );
    }
}
