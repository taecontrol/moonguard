<?php

namespace Taecontrol\MoonGuard\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Repositories\UserRepository;
use Taecontrol\MoonGuard\Events\ExceptionLogGroupUpdatedEvent;
use Taecontrol\MoonGuard\Notifications\ExceptionLogGroupNotification;

class ExceptionLogGroupUpdatedListener
{
    public function handle(ExceptionLogGroupUpdatedEvent $event): void
    {
        Notification::send(
            UserRepository::all(),
            new ExceptionLogGroupNotification($event->exceptionLogGroup)
        );
    }
}
