<?php

namespace Taecontrol\Larastats\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Taecontrol\Larastats\Contracts\LarastatsExceptionLogGroup;

class ExceptionLogGroupCreatedEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public LarastatsExceptionLogGroup $exceptionLogGroup)
    {
    }
}
