<?php

namespace Taecontrol\Larastats\ValueObjects;

use Carbon\CarbonInterface;
use Taecontrol\Larastats\Exceptions\InvalidPeriodException;

class Period
{
    public CarbonInterface $startDateTime;

    public CarbonInterface $endDateTime;

    /**
     * @throws InvalidPeriodException
     */
    public function __construct(CarbonInterface $startDateTime, CarbonInterface $endDateTime)
    {
        if ($startDateTime->gt($endDateTime)) {
            throw InvalidPeriodException::startDateMustComeBeforeEndDate($startDateTime, $endDateTime);
        }

        $this->startDateTime = $startDateTime;

        $this->endDateTime = $endDateTime;
    }

    public function duration(): string
    {
        $interval = $this->startDateTime->diff($this->endDateTime);

        if (! $this->startDateTime->diffInHours($this->endDateTime)) {
            return $interval->format('%im');
        }

        if (! $this->startDateTime->diffInDays($this->endDateTime)) {
            return $interval->format('%hh %im');
        }

        return $interval->format('%dd %hh %im');
    }

    public function toText(): string
    {
        $configuredDateFormat = 'd/m/Y';

        return
            $this->startDateTime->format('H:i') . ' '
            . ($this->startDateTime->isToday() ? '' : "on {$this->startDateTime->format($configuredDateFormat)} ")
            . '➡️ '
            . $this->endDateTime->format('H:i')
            . ($this->endDateTime->isToday() ? '' : " on {$this->endDateTime->format($configuredDateFormat)}");
    }
}
