<?php

namespace Taecontrol\Larastats\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Taecontrol\Larastats\ValueObjects\RequestDuration;
use Taecontrol\Larastats\Contracts\LarastatsUptimeCheck;

class RequestTookLongerThanMaxDurationEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public LarastatsUptimeCheck $uptimeCheck, public RequestDuration $maxRequestDuration)
    {
    }
}
