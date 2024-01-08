<?php

namespace Taecontrol\MoonGuard\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Repositories\UserRepository;
use Taecontrol\MoonGuard\Events\SystemMetricAlertEvent;
use Taecontrol\MoonGuard\Notifications\SlackNotifiable;
use Taecontrol\MoonGuard\Notifications\SystemMetricNotification;

class SystemMetricAlertListener
{
    use InteractsWithQueue;

    public function handle(SystemMetricAlertEvent $event)
    {
        $channels = config('moonguard.notifications.channels');

        $notifiablesForMail = UserRepository::all();
        $notifiablesForSlack = new SlackNotifiable();

        foreach ($channels as $channel) {
            if ($event->hardware_monitoring_notification_enabled) {
                $notifiables = ($channel === 'slack') ? $notifiablesForSlack : $notifiablesForMail;

                Notification::send(
                    $notifiables,
                    new SystemMetricNotification($event->site, $event->resource, $event->usage, $channel)
                );
            }
        }
    }
}
