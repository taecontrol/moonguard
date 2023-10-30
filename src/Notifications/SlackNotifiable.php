<?php

namespace Taecontrol\MoonGuard\Notifications;

use Illuminate\Notifications\Notifiable;

class SlackNotifiable
{
    use Notifiable;

    public function routeNotificationForSlack(): string
    {
        return config('moonguard.notifications.slack.webhook_url');
    }
}
