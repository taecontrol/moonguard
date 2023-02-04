<?php

namespace Taecontrol\MoonGuard\Enums;

enum UptimeStatus: string
{
    case NOT_YET_CHECKED = 'not yet checked';

    case UP = 'up';

    case DOWN = 'down';
}
