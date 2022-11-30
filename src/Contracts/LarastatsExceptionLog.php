<?php

namespace Taecontrol\Larastats\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * @property string|int $site_id
 * @property LarastatsSite $site
 */
interface LarastatsExceptionLog
{
    public function site(): HasOneThrough;

    public function exceptionLogGroup(): BelongsTo;
}
