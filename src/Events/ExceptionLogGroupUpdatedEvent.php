<?php

namespace Taecontrol\Moonguard\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Taecontrol\Moonguard\Contracts\MoonguardExceptionLogGroup;

class ExceptionLogGroupUpdatedEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public MoonguardExceptionLogGroup $exceptionLogGroup)
    {
    }
}
