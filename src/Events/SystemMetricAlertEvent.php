<?php

namespace Taecontrol\MoonGuard\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class SystemMetricAlertEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $site;

    public $resource;

    public $usage;

    public $hardware_monitoring_notification_enabled;

    public function __construct($site, $resource, $usage, $hardware_monitoring_notification_enabled)
    {
        $this->site = $site;
        $this->resource = $resource;
        $this->usage = $usage;
        $this->hardware_monitoring_notification_enabled = $hardware_monitoring_notification_enabled;
    }
}
