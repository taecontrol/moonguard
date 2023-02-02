<?php

namespace Taecontrol\Moonguard\Contracts;

use Illuminate\Support\Carbon;
use Taecontrol\Moonguard\Enums\ExceptionLogStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * @property string|int $site_id
 * @property string $type
 * @property string $file
 * @property ExceptionLogStatus $status
 * @property array $trace
 * @property array $request
 * @property Carbon $thrown_at
 * @property MoonguardSite $site
 * @property MoonguardExceptionLogGroup $exceptionLogGroup
 */
interface MoonguardExceptionLog
{
    public function site(): HasOneThrough;

    public function exceptionLogGroup(): BelongsTo;
}
