<?php

namespace Taecontrol\MoonGuard\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Repositories\UserRepository;
use Taecontrol\MoonGuard\Notifications\SlackNotifiable;
use Taecontrol\MoonGuard\Events\UptimeCheckRecoveredEvent;
use Taecontrol\MoonGuard\Notifications\UptimeCheckRecoveredNotification;

class UptimeCheckRecoveredListener
{
    public function handle(UptimeCheckRecoveredEvent $event): void
    {
        $channels = config('moonguard.notifications.channels');

        foreach ($channels as $channel) {
            $notifiables = ($channel === 'slack') ? new SlackNotifiable() : UserRepository::all();

            Notification::send(
                $users,
                new UptimeCheckRecoveredNotification(
                    $event->uptimeCheck,
                    $event->downtimePeriod,
                    $channel
                )
            );
        }
    }
}
