<?php

namespace Taecontrol\Larastats\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\Larastats\Repositories\UserRepository;
use Taecontrol\Larastats\Events\ExceptionLogGroupCreatedEvent;
use Taecontrol\Larastats\Notifications\NewExceptionLogGroupNotification;

class ExceptionLogGroupCreatedListener
{
    public function handle(ExceptionLogGroupCreatedEvent $event): void
    {
        Notification::send(
            UserRepository::all(),
            new NewExceptionLogGroupNotification($event->exceptionLogGroup)
        );
    }
}