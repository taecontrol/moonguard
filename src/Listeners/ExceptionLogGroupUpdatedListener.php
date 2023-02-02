<?php

namespace Taecontrol\Moonguard\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\Moonguard\Repositories\UserRepository;
use Taecontrol\Moonguard\Events\ExceptionLogGroupUpdatedEvent;
use Taecontrol\Moonguard\Notifications\ExceptionLogGroupNotification;

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
