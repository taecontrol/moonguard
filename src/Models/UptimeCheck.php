<?php

namespace Taecontrol\Larastats\Models;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Database\Eloquent\Model;
use Taecontrol\Larastats\Enums\UptimeStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Taecontrol\Larastats\Casts\RequestDurationCast;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Taecontrol\Larastats\Repositories\SiteRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Taecontrol\Larastats\ValueObjects\RequestDuration;
use Taecontrol\Larastats\Contracts\LarastatsUptimeCheck;
use Taecontrol\Larastats\Repositories\UptimeCheckRepository;
use Taecontrol\Larastats\Database\Factories\UptimeCheckFactory;

class UptimeCheck extends Model implements LarastatsUptimeCheck
{
    use HasFactory;

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
        return $this->belongsTo(SiteRepository::resolveModelClass());
    }

    public function saveSuccessfulCheck(Response $response): void
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

    public function saveFailedCheck(Response|Exception $response): void
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

    public function wasFailing(): Attribute
    {
        return Attribute::make(
            get: fn () => ! is_null($this->check_failed_event_fired_on_date),
        );
    }

    public function isEnabled(): Attribute
    {
        return Attribute::make(
            get: fn () => UptimeCheckRepository::isEnabled(),
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

    protected static function newFactory(): UptimeCheckFactory
    {
        return UptimeCheckFactory::new();
    }
}
