<?php

return [
    'user' => [
        'model' => \Taecontrol\MoonGuard\Models\User::class,
    ],
    'site' => [
        'model' => \Taecontrol\MoonGuard\Models\Site::class,
    ],
    'uptime_check' => [
        'enabled' => true,
        'model' => \Taecontrol\MoonGuard\Models\UptimeCheck::class,

        'notify_failed_check_after_consecutive_failures' => 1,
        'resend_uptime_check_failed_notification_every_minutes' => 5,
    ],
    'ssl_certificate_check' => [
        'enabled' => true,
        'model' => \Taecontrol\MoonGuard\Models\SslCertificateCheck::class,

        'notify_expiring_soon_if_certificate_expires_within_days' => 7,
        'cron_schedule' => '* * * * *',
    ],
    'exceptions' => [
        'enabled' => true,
        'notify_time_between_group_updates_in_minutes' => 15,
        'exception_log' => [
            'model' => \Taecontrol\MoonGuard\Models\ExceptionLog::class,
        ],
        'exception_log_group' => [
            'model' => \Taecontrol\MoonGuard\Models\ExceptionLogGroup::class,
        ],
    ],
    'routes' => [
        'prefix' => 'api',
        'middleware' => 'throttle:api',
    ],
    'events' => [
        'listen' => [
            \Taecontrol\MoonGuard\Events\UptimeCheckRecoveredEvent::class => [
                \Taecontrol\MoonGuard\Listeners\UptimeCheckRecoveredListener::class,
            ],
            \Taecontrol\MoonGuard\Events\UptimeCheckFailedEvent::class => [
                \Taecontrol\MoonGuard\Listeners\UptimeCheckFailedListener::class,
            ],
            \Taecontrol\MoonGuard\Events\RequestTookLongerThanMaxDurationEvent::class => [
                \Taecontrol\MoonGuard\Events\RequestTookLongerThanMaxDurationEvent::class,
            ],
            \Taecontrol\MoonGuard\Events\SslCertificateExpiresSoonEvent::class => [
                \Taecontrol\MoonGuard\Listeners\SslCertificateExpiresSoonListener::class,
            ],
            \Taecontrol\MoonGuard\Events\SslCertificateCheckFailedEvent::class => [
                \Taecontrol\MoonGuard\Listeners\SslCertificateCheckFailedListener::class,
            ],
            \Taecontrol\MoonGuard\Events\ExceptionLogGroupCreatedEvent::class => [
                \Taecontrol\MoonGuard\Listeners\ExceptionLogGroupCreatedListener::class,
            ],
            \Taecontrol\MoonGuard\Events\ExceptionLogGroupUpdatedEvent::class => [
                \Taecontrol\MoonGuard\Listeners\ExceptionLogGroupUpdatedListener::class,
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
