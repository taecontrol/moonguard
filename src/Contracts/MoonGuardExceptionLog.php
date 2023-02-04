<?php

namespace Taecontrol\MoonGuard\Contracts;

use Illuminate\Support\Carbon;
use Taecontrol\MoonGuard\Enums\ExceptionLogStatus;
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
 * @property MoonGuardSite $site
 * @property MoonGuardExceptionLogGroup $exceptionLogGroup
 */
interface MoonGuardExceptionLog
{
    public function site(): HasOneThrough;

    public function exceptionLogGroup(): BelongsTo;
}
