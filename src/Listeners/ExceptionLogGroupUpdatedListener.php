<?php

namespace Taecontrol\Larastats\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\Larastats\Repositories\UserRepository;
use Taecontrol\Larastats\Events\ExceptionLogGroupUpdatedEvent;
use Taecontrol\Larastats\Notifications\NewExceptionLogGroupNotification;

class ExceptionLogGroupUpdatedListener
{
    public function handle(ExceptionLogGroupUpdatedEvent $event): void
    {
        Notification::send(
            UserRepository::all(),
            new NewExceptionLogGroupNotification($event->exceptionLogGroup)
        );
    }
}
