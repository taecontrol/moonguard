<?php

namespace Taecontrol\Moonguard\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\Moonguard\Repositories\UserRepository;
use Taecontrol\Moonguard\Events\SslCertificateCheckFailedEvent;
use Taecontrol\Moonguard\Notifications\SslCertificateCheckFailedNotification;

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
