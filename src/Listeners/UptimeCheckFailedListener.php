<?php

namespace Taecontrol\Moonguard\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\Moonguard\Repositories\UserRepository;
use Taecontrol\Moonguard\Events\UptimeCheckFailedEvent;
use Taecontrol\Moonguard\Notifications\UptimeCheckFailedNotification;

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
