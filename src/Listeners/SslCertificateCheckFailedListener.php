<?php

namespace Taecontrol\Larastats\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\Larastats\Repositories\UserRepository;
use Taecontrol\Larastats\Events\SslCertificateCheckFailedEvent;
use Taecontrol\Larastats\Notifications\SslCertificateCheckFailedNotification;

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
