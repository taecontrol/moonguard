<?php

return [
    'user' => [
        'model' => \Taecontrol\Moonguard\Models\User::class,
    ],
    'site' => [
        'model' => \Taecontrol\Moonguard\Models\Site::class,
    ],
    'uptime_check' => [
        'enabled' => true,
        'model' => \Taecontrol\Moonguard\Models\UptimeCheck::class,

        'notify_failed_check_after_consecutive_failures' => 1,
        'resend_uptime_check_failed_notification_every_minutes' => 5,
    ],
    'ssl_certificate_check' => [
        'enabled' => true,
        'model' => \Taecontrol\Moonguard\Models\SslCertificateCheck::class,

        'notify_expiring_soon_if_certificate_expires_within_days' => 7,
        'cron_schedule' => '* * * * *',
    ],
    'exceptions' => [
        'enabled' => true,
        'notify_time_between_group_updates_in_minutes' => 15,
        'exception_log' => [
            'model' => \Taecontrol\Moonguard\Models\ExceptionLog::class,
        ],
        'exception_log_group' => [
            'model' => \Taecontrol\Moonguard\Models\ExceptionLogGroup::class,
        ],
    ],
    'routes' => [
        'prefix' => 'api',
        'middleware' => 'throttle:api',
    ],
    'events' => [
        'listen' => [
            \Taecontrol\Moonguard\Events\UptimeCheckRecoveredEvent::class => [
                \Taecontrol\Moonguard\Listeners\UptimeCheckRecoveredListener::class,
            ],
            \Taecontrol\Moonguard\Events\UptimeCheckFailedEvent::class => [
                \Taecontrol\Moonguard\Listeners\UptimeCheckFailedListener::class,
            ],
            \Taecontrol\Moonguard\Events\RequestTookLongerThanMaxDurationEvent::class => [
                \Taecontrol\Moonguard\Events\RequestTookLongerThanMaxDurationEvent::class,
            ],
            \Taecontrol\Moonguard\Events\SslCertificateExpiresSoonEvent::class => [
                \Taecontrol\Moonguard\Listeners\SslCertificateExpiresSoonListener::class,
            ],
            \Taecontrol\Moonguard\Events\SslCertificateCheckFailedEvent::class => [
                \Taecontrol\Moonguard\Listeners\SslCertificateCheckFailedListener::class,
            ],
            \Taecontrol\Moonguard\Events\ExceptionLogGroupCreatedEvent::class => [
                \Taecontrol\Moonguard\Listeners\ExceptionLogGroupCreatedListener::class,
            ],
            \Taecontrol\Moonguard\Events\ExceptionLogGroupUpdatedEvent::class => [
                \Taecontrol\Moonguard\Listeners\ExceptionLogGroupUpdatedListener::class,
            ],
        ],
    ],
    'notifications' => [
        'channels' => ['mail', 'slack'],
        'slack' => [
            'webhook_url' => env('SLACK_WEBHOOK_URL'),
        ],
    ],
];
