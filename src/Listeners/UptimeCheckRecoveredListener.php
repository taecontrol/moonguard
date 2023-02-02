<?php

namespace Taecontrol\Moonguard\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\Moonguard\Repositories\UserRepository;
use Taecontrol\Moonguard\Events\UptimeCheckRecoveredEvent;
use Taecontrol\Moonguard\Notifications\UptimeCheckRecoveredNotification;

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
