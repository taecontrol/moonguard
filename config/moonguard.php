<?php

return [
    'user' => [
        /*
         * The user model to use.
         */
        'model' => \Taecontrol\MoonGuard\Models\User::class,
    ],
    'site' => [
        /*
         * The site model to use.
         */
        'model' => \Taecontrol\MoonGuard\Models\Site::class,
    ],
    'uptime_check' => [
        /*
         * Enable or disable uptime checks globally.
         */
        'enabled' => true,

        /*
         * The uptime check model to use.
         */
        'model' => \Taecontrol\MoonGuard\Models\UptimeCheck::class,

        /*
         * The number of consecutive failures before a notification should be sent.
         */
        'notify_failed_check_after_consecutive_failures' => 1,

        /*
         * How often a notification is resent after the uptime check fails
        */
        'resend_uptime_check_failed_notification_every_minutes' => 5,
    ],
    'ssl_certificate_check' => [
        /*
         * Enable or disable ssl certificate checks globally.
         */
        'enabled' => true,

        /*
         * The ssl certificate check model to use.
         */
        'model' => \Taecontrol\MoonGuard\Models\SslCertificateCheck::class,

        /*
         * The number of days before a certificate expires to send a notification.
         */
        'notify_expiring_soon_if_certificate_expires_within_days' => 7,
    ],
    'exceptions' => [
        /*
         * Enable or disable exception logging globally.
         */
        'enabled' => true,

        /*
         * The number of minutes that should be waited before sending a notification about exception log group updates.
         */
        'notify_time_between_group_updates_in_minutes' => 15,

        'exception_log' => [
            /*
             * The exception log model to use.
             */
            'model' => \Taecontrol\MoonGuard\Models\ExceptionLog::class,
        ],

        'exception_log_group' => [
            /*
             * The exception log group model to use.
             */
            'model' => \Taecontrol\MoonGuard\Models\ExceptionLogGroup::class,
        ],
    ],
    'routes' => [
        /*
         * The prefix for the MoonGuard API routes.
         */
        'prefix' => 'moonguard/api',

        /*
         * The middleware for the MoonGuard API routes.
         */
        'middleware' => 'throttle:api',
    ],
    'events' => [
        /*
         * The events that can be listened for.
         * You can add your own listeners here.
         */
        'listen' => [
            \Taecontrol\MoonGuard\Events\UptimeCheckRecoveredEvent::class => [
                \Taecontrol\MoonGuard\Listeners\UptimeCheckRecoveredListener::class,
            ],
            \Taecontrol\MoonGuard\Events\UptimeCheckFailedEvent::class => [
                \Taecontrol\MoonGuard\Listeners\UptimeCheckFailedListener::class,
            ],
            \Taecontrol\MoonGuard\Events\RequestTookLongerThanMaxDurationEvent::class => [
                \Taecontrol\MoonGuard\Listeners\RequestTookLongerThanMaxDurationListener::class,
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
        /*
         * The notification channels that are used by default.
         */
        'channels' => ['mail'],
    ],
];
