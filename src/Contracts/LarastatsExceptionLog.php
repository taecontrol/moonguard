<?php

namespace Taecontrol\Larastats\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|int $site_id
 * @property LarastatsSite $site
 */
interface LarastatsExceptionLog
{
    public function site(): BelongsTo;
}
