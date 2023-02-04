<?php

namespace Taecontrol\MoonGuard\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Taecontrol\MoonGuard\ValueObjects\RequestDuration;
use Taecontrol\MoonGuard\Contracts\MoonGuardUptimeCheck;

class RequestTookLongerThanMaxDurationEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public MoonGuardUptimeCheck $uptimeCheck, public RequestDuration $maxRequestDuration)
    {
    }
}
