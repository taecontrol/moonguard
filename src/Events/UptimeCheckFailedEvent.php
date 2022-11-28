<?php

namespace Taecontrol\Larastats\Events;

use Illuminate\Queue\SerializesModels;
use Taecontrol\Larastats\ValueObjects\Period;
use Illuminate\Foundation\Events\Dispatchable;
use Taecontrol\Larastats\Contracts\LarastatsUptimeCheck;

class UptimeCheckFailedEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public LarastatsUptimeCheck $uptimeCheck, public Period $downtimePeriod)
    {
    }
}
