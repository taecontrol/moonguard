<?php

namespace Taecontrol\Larastats\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\Larastats\Repositories\UserRepository;
use Taecontrol\Larastats\Events\UptimeCheckRecoveredEvent;
use Taecontrol\Larastats\Notifications\UptimeCheckRecoveredNotification;

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
