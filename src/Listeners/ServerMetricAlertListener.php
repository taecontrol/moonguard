<?php

namespace Taecontrol\MoonGuard\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Repositories\UserRepository;
use Taecontrol\MoonGuard\Events\ServerMetricAlertEvent;
use Taecontrol\MoonGuard\Notifications\SlackNotifiable;
use Taecontrol\MoonGuard\Notifications\ServerMetricNotification;

class ServerMetricAlertListener
{
    use InteractsWithQueue;

    public function handle(ServerMetricAlertEvent $event)
    {
        $channels = config('moonguard.notifications.channels');

        $notifiablesForMail = UserRepository::all();
        $notifiablesForSlack = new SlackNotifiable();

        foreach ($channels as $channel) {
            if ($event->server_monitoring_notification_enabled) {
                $notifiables = ($channel === 'slack') ? $notifiablesForSlack : $notifiablesForMail;

                Notification::send(
                    $notifiables,
                    new ServerMetricNotification($event->site, $event->resource, $event->usage, $channel)
                );
            }
        }
    }
}
