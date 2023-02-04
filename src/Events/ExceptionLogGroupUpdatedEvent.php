<?php

namespace Taecontrol\MoonGuard\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Taecontrol\MoonGuard\Contracts\MoonGuardExceptionLogGroup;

class ExceptionLogGroupUpdatedEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public MoonGuardExceptionLogGroup $exceptionLogGroup)
    {
    }
}
