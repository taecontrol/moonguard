<?php

namespace Taecontrol\MoonGuard\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Repositories\UserRepository;
use Taecontrol\MoonGuard\Events\ExceptionLogGroupCreatedEvent;
use Taecontrol\MoonGuard\Notifications\ExceptionLogGroupNotification;

class ExceptionLogGroupCreatedListener
{
    public function handle(ExceptionLogGroupCreatedEvent $event): void
    {
        Notification::send(
            UserRepository::all(),
            new ExceptionLogGroupNotification($event->exceptionLogGroup)
        );
    }
}
