<?php

namespace Taecontrol\Larastats\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Taecontrol\Larastats\Contracts\LarastatsUptimeCheck;
use Taecontrol\Larastats\ValueObjects\RequestDuration;

class RequestTookLongerThanMaxDurationEvent
{
    use Dispatchable, SerializesModels;

    public function __construct(public LarastatsUptimeCheck $uptimeCheck, public RequestDuration $maxRequestDuration)
    {}
}
