<?php

namespace Taecontrol\Larastats\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use Taecontrol\Larastats\ValueObjects\RequestDuration;

class RequestDurationCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return RequestDuration::from($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (! $value instanceof RequestDuration) {
            throw new InvalidArgumentException('The given value is not an RequestDuration instance.');
        }

        return $value->milliseconds;
    }
}
