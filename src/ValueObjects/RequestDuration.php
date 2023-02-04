<?php

namespace Taecontrol\MoonGuard\ValueObjects;

use InvalidArgumentException;

class RequestDuration
{
    public function __construct(public ?int $milliseconds)
    {
        if ($this->milliseconds < 0) {
            throw new InvalidArgumentException('The request duration must be positive');
        }
    }

    public static function from(?int $milliseconds): RequestDuration
    {
        return new self($milliseconds);
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
