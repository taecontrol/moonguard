<?php

namespace Taecontrol\MoonGuard\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Repositories\UserRepository;
use Taecontrol\MoonGuard\Events\SslCertificateCheckFailedEvent;
use Taecontrol\MoonGuard\Notifications\SslCertificateCheckFailedNotification;

class SslCertificateCheckFailedListener
{
    public function handle(SslCertificateCheckFailedEvent $event): void
    {
        Notification::send(
            UserRepository::all(),
            new SslCertificateCheckFailedNotification($event->sslCertificateCheck)
        );
    }
}
