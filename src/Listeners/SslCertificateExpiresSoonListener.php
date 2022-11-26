<?php

namespace Taecontrol\Larastats\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\Larastats\Events\SslCertificateExpiresSoonEvent;
use Taecontrol\Larastats\Notifications\SslCertificateExpiresSoonNotification;
use Taecontrol\Larastats\Repositories\UserRepository;

class SslCertificateExpiresSoonListener
{
    public function handle(SslCertificateExpiresSoonEvent $event): void
    {
        Notification::send(
            UserRepository::all(),
            new SslCertificateExpiresSoonNotification($event->sslCertificateCheck)
        );
    }
}
