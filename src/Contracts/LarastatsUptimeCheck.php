<?php

namespace Taecontrol\Larastats\Contracts;

use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Carbon;
use Taecontrol\Larastats\ValueObjects\RequestDuration;

/**
 * @property string|int $site_id
 * @property Carbon $last_check_date
 * @property Carbon $status_last_change_date
 * @property Carbon $check_failed_event_fired_on_date
 * @property RequestDuration $request_duration_ms
 * @property int $check_times_failed_in_a_row
 * @property bool $was_failing
 * @property LarastatsSite $site
 */
interface LarastatsUptimeCheck
{
    public function site(): BelongsTo;

    public function saveSuccessfulCheck(Response $response): void;

    public function saveFailedCheck(Response|Exception $response): void;

    public function requestTookTooLong(): bool;

    public function wasFailing(): Attribute;
}
