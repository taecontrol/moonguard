<?php

return [
    'user' => [
        'model' => \Taecontrol\Larastats\Models\User::class,
    ],
    'site' => [
        'model' => \Taecontrol\Larastats\Models\Site::class,
    ],
    'uptime_check' => [
        'model' => \Taecontrol\Larastats\Models\UptimeCheck::class,

        'notify_failed_check_after_consecutive_failures' => 1,
        'resend_uptime_check_failed_notification_every_minutes' => 5,
    ]
];
