<?php

namespace Taecontrol\MoonGuard\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ServerMetricAlertEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $site;

    public $resource;

    public $usage;

    public $server_monitoring_notification_enabled;

    public function __construct($site, $resource, $usage, $server_monitoring_notification_enabled)
    {
        $this->site = $site;
        $this->resource = $resource;
        $this->usage = $usage;
        $this->server_monitoring_notification_enabled = $server_monitoring_notification_enabled;
    }
}
