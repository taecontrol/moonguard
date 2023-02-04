<?php

namespace Taecontrol\MoonGuard\Events;

use Illuminate\Queue\SerializesModels;
use Taecontrol\MoonGuard\ValueObjects\Period;
use Illuminate\Foundation\Events\Dispatchable;
use Taecontrol\MoonGuard\Contracts\MoonGuardUptimeCheck;

class UptimeCheckFailedEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public MoonGuardUptimeCheck $uptimeCheck, public Period $downtimePeriod)
    {
    }
}
