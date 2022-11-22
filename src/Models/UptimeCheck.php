<?php

namespace Taecontrol\Larastats\Models;

use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Client\Response;
use Taecontrol\Larastats\Casts\RequestDurationCast;
use Taecontrol\Larastats\Enums\UptimeStatus;
use Taecontrol\Larastats\ValueObjects\RequestDuration;

class UptimeCheck extends Model
{
    protected $fillable = [
        'site_id',
    ];

    protected $casts = [
        'status' => UptimeStatus::class,
        'status_last_change_date' => 'immutable_datetime',
        'last_check_date' => 'immutable_datetime',
        'check_failed_event_fired_on_date' => 'immutable_datetime',
        'request_duration_ms' => RequestDurationCast::class,
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(config('larastats.site.model'));
    }

    public function saveSuccessfulCheck(Response $response)
    {
        $this->status = UptimeStatus::UP;
        $this->check_failure_reason = '';
        $this->check_times_failed_in_a_row = 0;
        $this->last_check_date = now();
        $this->request_duration_ms = RequestDuration::from(
            round(data_get($response->handlerStats(), 'total_time_us') / 1000)
        );

        $this->save();
    }

    public function saveFailedCheck(Response|Exception $response)
    {
        $this->status = UptimeStatus::DOWN;
        $this->check_times_failed_in_a_row++;
        $this->last_check_date = now();
        $this->check_failure_reason = $response instanceof Response ? $response->reason() : $response->getMessage();
        $this->request_duration_ms = RequestDuration::from(null);
        $this->save();
    }

    public function requestTookTooLong(): bool
    {
        /** @var RequestDuration $maxRequestDuration */
        $maxRequestDuration = $this->site->max_request_duration_ms;

        return $this->request_duration_ms->toRawMilliseconds() >= $maxRequestDuration->toRawMilliseconds();
    }

    protected function wasFailing(): Attribute
    {
        return Attribute::make(
            get: fn () => ! is_null($this->check_failed_event_fired_on_date),
        );
    }

    protected static function booted()
    {
        static::saving(function (self $uptime) {
            if (is_null($uptime->status_last_change_date)) {
                $uptime->status_last_change_date = now();

                return;
            }

            if ($uptime->getOriginal('status') != $uptime->status) {
                $uptime->status_last_change_date = now();
            }
        });
    }
}
