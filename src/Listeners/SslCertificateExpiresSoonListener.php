<?php

namespace Taecontrol\MoonGuard\Listeners;

use Illuminate\Support\Facades\Cache;
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
        $lastNotificationTimeKey = 'ssl_certificate_check.last_notification_time';
        $notificationFrequencyMinutes = config('moonguard.ssl_certificate_check.notification_frequency_minutes');

        foreach ($channels as $channel) {
            $lastNotificationTime = Cache::get($lastNotificationTimeKey, now()->subYears(1));
            if (now()->diffInMinutes($lastNotificationTime) < $notificationFrequencyMinutes) {
                continue;
            }
            $notifiables = ($channel === 'slack') ? new SlackNotifiable() : UserRepository::all();

            Notification::send(
                $notifiables,
                new SslCertificateExpiresSoonNotification($event->sslCertificateCheck, $channel)
            );

            Cache::put($lastNotificationTimeKey, now(), now()->addMinutes($notificationFrequencyMinutes));
        }
    }
}
