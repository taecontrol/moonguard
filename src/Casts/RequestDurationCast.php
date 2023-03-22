<?php

namespace Taecontrol\MoonGuard\Casts;

use InvalidArgumentException;
use Taecontrol\MoonGuard\ValueObjects\RequestDuration;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class RequestDurationCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes): RequestDuration
    {
        return RequestDuration::from($value);
    }

    public function set($model, string $key, $value, array $attributes): int | null
    {
        if (! $value instanceof RequestDuration) {
            throw new InvalidArgumentException('The given value is not an RequestDuration instance.');
        }

        return $value->milliseconds;
    }
}
