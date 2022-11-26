<?php

namespace Taecontrol\Larastats\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\Larastats\Events\SslCertificateCheckFailedEvent;
use Taecontrol\Larastats\Notifications\SslCertificateCheckFailedNotification;
use Taecontrol\Larastats\Repositories\UserRepository;

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
