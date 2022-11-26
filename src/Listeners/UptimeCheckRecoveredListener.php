<?php

namespace Taecontrol\Larastats\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\Larastats\Events\UptimeCheckRecoveredEvent;
use Taecontrol\Larastats\Notifications\UptimeCheckRecoveredNotification;
use Taecontrol\Larastats\Repositories\UserRepository;

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
