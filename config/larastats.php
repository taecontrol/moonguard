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
        'exception_log' => [
            'model' => \Taecontrol\Larastats\Models\ExceptionLog::class,
        ],
        'exception_log_group' => [
            'model' => \Taecontrol\Larastats\Models\ExceptionLogGroup::class,
        ],
    ],
    'routes' => [
        'prefix' => 'api',
        'middleware' => 'api'
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
            ]
        ]
    ]
];
