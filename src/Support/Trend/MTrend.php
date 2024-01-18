<?php

namespace Taecontrol\MoonGuard\Support\Trend;

use Carbon\CarbonPeriod;
use Flowframe\Trend\Trend;
use Illuminate\Support\Collection;

class MTrend extends Trend
{
    public string $timeFrequency = "1";

    public function timeFrequency(string $time): self
    {
        $this->timeFrequency = $time;

        return $this;
    }

    protected function getDatePeriod(): Collection
    {
        return collect(
            CarbonPeriod::between(
                $this->start,
                $this->end,
            )->interval("{$this->timeFrequency} {$this->interval}")
        );
    }
}
