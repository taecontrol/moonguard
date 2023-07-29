<?php

namespace Taecontrol\MoonGuard\ValueObjects;

use InvalidArgumentException;

class RequestDuration
{
    public ?int $milliseconds;

    public static function from(?int $milliseconds): RequestDuration
    {
        if ($milliseconds < 0) {
            throw new InvalidArgumentException('The request duration must be positive');
        }

        return (new self())->setMilliseconds($milliseconds);
    }

    public function setMilliseconds(?int $milliseconds): self
    {
        $this->milliseconds = $milliseconds;

        return $this;
    }

    public function toMilliseconds(): string
    {
        if ($this->milliseconds === null) {
            return $this->noValue();
        }

        return $this->toRawMilliseconds() . ' ms';
    }

    public function toSeconds(): float
    {
        if ($this->milliseconds === null) {
            return $this->noValue();
        }

        return $this->toRawSeconds() . ' s';
    }

    public function toRawMilliseconds(): ?float
    {
        return $this->milliseconds ?: null;
    }

    public function toRawSeconds(): ?float
    {
        return $this->milliseconds ? $this->milliseconds / 1000 : null;
    }

    public function noValue(): string
    {
        return '---';
    }
}
