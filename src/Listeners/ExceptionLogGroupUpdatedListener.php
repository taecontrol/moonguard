<?php

namespace Taecontrol\MoonGuard\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Repositories\UserRepository;
use Taecontrol\MoonGuard\Notifications\SlackNotifiable;
use Taecontrol\MoonGuard\Events\ExceptionLogGroupUpdatedEvent;
use Taecontrol\MoonGuard\Notifications\ExceptionLogGroupNotification;

class ExceptionLogGroupUpdatedListener
{
    public function handle(ExceptionLogGroupUpdatedEvent $event): void
    {
        $channels = config('moonguard.notifications.channels');

        foreach ($channels as $channel) {
            $notifiables = ($channel === 'slack') ? new SlackNotifiable() : UserRepository::all();

            Notification::send(
                $users,
                new ExceptionLogGroupNotification($event->exceptionLogGroup, $channel)
            );
        }
    }
}
