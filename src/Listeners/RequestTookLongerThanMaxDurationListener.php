<?php

namespace Taecontrol\Larastats\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\Larastats\Repositories\UserRepository;
use Taecontrol\Larastats\Events\RequestTookLongerThanMaxDurationEvent;
use Taecontrol\Larastats\Notifications\RequestTookLongerThanMaxDurationNotification;

class RequestTookLongerThanMaxDurationListener
{
    public function handle(RequestTookLongerThanMaxDurationEvent $event): void
    {
        Notification::send(
            UserRepository::all(),
            new RequestTookLongerThanMaxDurationNotification($event->uptimeCheck, $event->maxRequestDuration)
        );
    }
}
