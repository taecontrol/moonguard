<?php

namespace Taecontrol\MoonGuard\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Repositories\UserRepository;
use Taecontrol\MoonGuard\Notifications\SlackNotifiable;
use Taecontrol\MoonGuard\Events\RequestTookLongerThanMaxDurationEvent;
use Taecontrol\MoonGuard\Notifications\RequestTookLongerThanMaxDurationNotification;

class RequestTookLongerThanMaxDurationListener
{
    public function handle(RequestTookLongerThanMaxDurationEvent $event): void
    {
        $channels = config('moonguard.notifications.channels');

        foreach ($channels as $channel) {
            $users = ($channel === 'slack') ? new SlackNotifiable() : UserRepository::all();

            Notification::send(
                $users,
                new RequestTookLongerThanMaxDurationNotification(
                    $event->uptimeCheck,
                    $event->maxRequestDuration,
                    $channel
                )
            );
        }
    }
}
