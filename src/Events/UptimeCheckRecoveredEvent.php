<?php

namespace Taecontrol\Larastats\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Taecontrol\Larastats\Contracts\LarastatsUptimeCheck;
use Taecontrol\Larastats\ValueObjects\Period;

class UptimeCheckRecoveredEvent
{
    use Dispatchable, SerializesModels;

    public function __construct(public LarastatsUptimeCheck $uptimeCheck, public Period $downtimePeriod)
    {}
}
