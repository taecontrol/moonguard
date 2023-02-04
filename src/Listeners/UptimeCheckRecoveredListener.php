<?php

namespace Taecontrol\MoonGuard\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Repositories\UserRepository;
use Taecontrol\MoonGuard\Events\UptimeCheckRecoveredEvent;
use Taecontrol\MoonGuard\Notifications\UptimeCheckRecoveredNotification;

class UptimeCheckRecoveredListener
{
    public function handle(UptimeCheckRecoveredEvent $event): void
    {
        Notification::send(
            UserRepository::all(),
            new UptimeCheckRecoveredNotification($event->uptimeCheck, $event->downtimePeriod)
        );
    }
}
