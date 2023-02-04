<?php

namespace Taecontrol\MoonGuard\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Repositories\UserRepository;
use Taecontrol\MoonGuard\Events\SslCertificateExpiresSoonEvent;
use Taecontrol\MoonGuard\Notifications\SslCertificateExpiresSoonNotification;

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
