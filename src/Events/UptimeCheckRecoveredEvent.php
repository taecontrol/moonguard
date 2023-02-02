<?php

namespace Taecontrol\Moonguard\Events;

use Illuminate\Queue\SerializesModels;
use Taecontrol\Moonguard\ValueObjects\Period;
use Illuminate\Foundation\Events\Dispatchable;
use Taecontrol\Moonguard\Contracts\MoonguardUptimeCheck;

class UptimeCheckRecoveredEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public MoonguardUptimeCheck $uptimeCheck, public Period $downtimePeriod)
    {
    }
}
