<?php

namespace Taecontrol\Moonguard\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\Moonguard\Repositories\UserRepository;
use Taecontrol\Moonguard\Events\ExceptionLogGroupCreatedEvent;
use Taecontrol\Moonguard\Notifications\ExceptionLogGroupNotification;

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
