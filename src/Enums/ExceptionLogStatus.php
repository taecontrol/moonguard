<?php

namespace Taecontrol\Moonguard\Enums;

enum ExceptionLogStatus: string
{
    case UNRESOLVED = 'unresolved';

    case RESOLVED = 'resolved';

    case IGNORED = 'ignored';

    case REVIEWED = 'reviewed';
}
