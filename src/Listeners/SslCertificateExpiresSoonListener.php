<?php

namespace Taecontrol\MoonGuard\Listeners;

use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Repositories\UserRepository;
use Taecontrol\MoonGuard\Notifications\SlackNotifiable;
use Taecontrol\MoonGuard\Events\SslCertificateExpiresSoonEvent;
use Taecontrol\MoonGuard\Notifications\SslCertificateExpiresSoonNotification;

class SslCertificateExpiresSoonListener
{
    public function handle(SslCertificateExpiresSoonEvent $event): void
    {
        $channels = config('moonguard.notifications.channels');

        foreach ($channels as $channel) {
            $users = ($channel === 'slack') ? new SlackNotifiable() : UserRepository::all();

            Notification::send(
                $users,
                new SslCertificateExpiresSoonNotification($event->sslCertificateCheck, $channel)
            );
        }
    }
}
