<?php

namespace Taecontrol\Larastats\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string|int $site_id
 * @property LarastatsSite $site
 */
interface LarastatsExceptionLogGroup
{
    public function exceptionLogs(): HasMany;

    public function site(): BelongsTo;
}
