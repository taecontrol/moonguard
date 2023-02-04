<?php

namespace Taecontrol\MoonGuard\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Widgets\Concerns\CanPoll;

abstract class PollableWidget extends Widget
{
    use CanPoll;
}
