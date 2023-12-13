<?php

namespace Taecontrol\MoonGuard\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class SystemMetricEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $site;

    public $resource;

    public $usage;

    public $monitoring_notification_enabled;

    public function __construct($site, $resource, $usage, $monitoring_notification_enabled)
    {
        $this->site = $site;
        $this->resource = $resource;
        $this->usage = $usage;
        $this->monitoring_notification_enabled = $monitoring_notification_enabled;
    }
}
