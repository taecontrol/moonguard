<?php

namespace Taecontrol\Larastats\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\Larastats\Repositories\UserRepository;
use Taecontrol\Larastats\Events\UptimeCheckFailedEvent;
use Taecontrol\Larastats\Notifications\UptimeCheckFailedNotification;

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
