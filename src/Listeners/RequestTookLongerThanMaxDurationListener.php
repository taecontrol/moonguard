<?php

namespace Taecontrol\MoonGuard\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Repositories\UserRepository;
use Taecontrol\MoonGuard\Events\RequestTookLongerThanMaxDurationEvent;
use Taecontrol\MoonGuard\Notifications\RequestTookLongerThanMaxDurationNotification;

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
