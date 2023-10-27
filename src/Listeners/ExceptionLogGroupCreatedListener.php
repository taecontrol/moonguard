<?php

namespace Taecontrol\MoonGuard\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Repositories\UserRepository;
use Taecontrol\MoonGuard\Notifications\SlackNotifiable;
use Taecontrol\MoonGuard\Events\ExceptionLogGroupCreatedEvent;
use Taecontrol\MoonGuard\Notifications\ExceptionLogGroupNotification;

class ExceptionLogGroupCreatedListener
{
    public function handle(ExceptionLogGroupCreatedEvent $event): void
    {
        $channels = config('moonguard.notifications.channels');

        foreach ($channels as $channel) {
            $users = ($channel === 'slack') ? new SlackNotifiable() : UserRepository::all();

            Notification::send(
                $users,
                new ExceptionLogGroupNotification($event->exceptionLogGroup, $channel)
            );
        }
    }
}
