<?php

namespace Taecontrol\Moonguard\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\Moonguard\Repositories\UserRepository;
use Taecontrol\Moonguard\Events\SslCertificateExpiresSoonEvent;
use Taecontrol\Moonguard\Notifications\SslCertificateExpiresSoonNotification;

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
