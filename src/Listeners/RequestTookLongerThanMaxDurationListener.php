<?php

namespace Taecontrol\Larastats\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\Larastats\Events\RequestTookLongerThanMaxDurationEvent;
use Taecontrol\Larastats\Notifications\RequestTookLongerThanMaxDurationNotification;
use Taecontrol\Larastats\Repositories\UserRepository;

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
