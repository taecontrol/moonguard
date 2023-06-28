<?php

namespace Taecontrol\MoonGuard;

use Filament\Support\Assets\Theme;

class MoonGuardTheme extends Theme
{
    public function getHref(): string
    {
       return asset($this->path);
    }
}
