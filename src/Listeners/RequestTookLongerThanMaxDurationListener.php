<?php

namespace Taecontrol\Moonguard\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\Moonguard\Repositories\UserRepository;
use Taecontrol\Moonguard\Events\RequestTookLongerThanMaxDurationEvent;
use Taecontrol\Moonguard\Notifications\RequestTookLongerThanMaxDurationNotification;

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
