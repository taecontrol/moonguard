<?php

namespace Taecontrol\MoonGuard\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Repositories\UserRepository;
use Taecontrol\MoonGuard\Events\UptimeCheckFailedEvent;
use Taecontrol\MoonGuard\Notifications\SlackNotifiable;
use Taecontrol\MoonGuard\Notifications\UptimeCheckFailedNotification;

class UptimeCheckFailedListener
{
    public function handle(UptimeCheckFailedEvent $event): void
    {
        $channels = config('moonguard.notifications.channels');

        foreach ($channels as $channel) {
            $notifiables = ($channel === 'slack') ? new SlackNotifiable() : UserRepository::all();

            Notification::send(
                $notifiables,
                new UptimeCheckFailedNotification(
                    $event->uptimeCheck,
                    $event->downtimePeriod,
                    $channel
                )
            );
        }
    }
}
