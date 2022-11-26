<?php

namespace Taecontrol\Larastats\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\Larastats\Events\UptimeCheckFailedEvent;
use Taecontrol\Larastats\Notifications\UptimeCheckFailedNotification;
use Taecontrol\Larastats\Repositories\UserRepository;

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
