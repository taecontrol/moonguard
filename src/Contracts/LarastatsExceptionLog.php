<?php

namespace Taecontrol\Larastats\Contracts;

use Illuminate\Support\Carbon;
use Taecontrol\Larastats\Enums\ExceptionLogStatus;
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
 * @property LarastatsSite $site
 * @property LarastatsExceptionLogGroup $exceptionLogGroup
 */
interface LarastatsExceptionLog
{
    public function site(): HasOneThrough;

    public function exceptionLogGroup(): BelongsTo;
}
