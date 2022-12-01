<?php

return [
    'user' => [
        'model' => \Taecontrol\Larastats\Models\User::class,
    ],
    'site' => [
        'model' => \Taecontrol\Larastats\Models\Site::class,
    ],
    'uptime_check' => [
        'enabled' => true,
        'model' => \Taecontrol\Larastats\Models\UptimeCheck::class,

        'notify_failed_check_after_consecutive_failures' => 1,
        'resend_uptime_check_failed_notification_every_minutes' => 5,
    ],
    'ssl_certificate_check' => [
        'enabled' => true,
        'model' => \Taecontrol\Larastats\Models\SslCertificateCheck::class,

        'notify_expiring_soon_if_certificate_expires_within_days' => 7,
        'cron_schedule' => '* * * * *',
    ],
    'exceptions' => [
        'enabled' => true,
        'notifications' => [
            'time_in_minutes_between_group_updates' => 15,
        ],
        'exception_log' => [
            'model' => \Taecontrol\Larastats\Models\ExceptionLog::class,
        ],
        'exception_log_group' => [
            'model' => \Taecontrol\Larastats\Models\ExceptionLogGroup::class,
        ],
    ],
    'routes' => [
        'prefix' => 'api',
        'middleware' => 'api',
    ],
    'events' => [
        'listen' => [
            \Taecontrol\Larastats\Events\UptimeCheckRecoveredEvent::class => [
                \Taecontrol\Larastats\Listeners\UptimeCheckRecoveredListener::class,
            ],
            \Taecontrol\Larastats\Events\UptimeCheckFailedEvent::class => [
                \Taecontrol\Larastats\Listeners\UptimeCheckFailedListener::class,
            ],
            \Taecontrol\Larastats\Events\RequestTookLongerThanMaxDurationEvent::class => [
                \Taecontrol\Larastats\Events\RequestTookLongerThanMaxDurationEvent::class,
            ],
            \Taecontrol\Larastats\Events\SslCertificateExpiresSoonEvent::class => [
                \Taecontrol\Larastats\Listeners\SslCertificateExpiresSoonListener::class,
            ],
            \Taecontrol\Larastats\Events\SslCertificateCheckFailedEvent::class => [
                \Taecontrol\Larastats\Listeners\SslCertificateCheckFailedListener::class,
            ],
            \Taecontrol\Larastats\Events\ExceptionLogGroupCreatedEvent::class => [
                \Taecontrol\Larastats\Listeners\ExceptionLogGroupCreatedListener::class,
            ],
            \Taecontrol\Larastats\Events\ExceptionLogGroupUpdatedEvent::class => [
                \Taecontrol\Larastats\Listeners\ExceptionLogGroupUpdatedListener::class,
            ],
        ],
    ],
    'notifications' => [
        'channels' => ['mail', 'slack'],
    ],
];
