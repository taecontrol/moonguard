<?php

namespace Taecontrol\Moonguard\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Taecontrol\Moonguard\ValueObjects\RequestDuration;
use Taecontrol\Moonguard\Contracts\MoonguardUptimeCheck;

class RequestTookLongerThanMaxDurationEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public MoonguardUptimeCheck $uptimeCheck, public RequestDuration $maxRequestDuration)
    {
    }
}
