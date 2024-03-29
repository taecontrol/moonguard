<?php

namespace Taecontrol\MoonGuard\Contracts;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|int $site_id
 * @property string $message
 * @property string $type
 * @property int $line
 * @property Carbon $first_seen
 * @property Carbon $last_seen
 * @property MoonGuardSite $site
 */
interface MoonGuardExceptionLogGroup
{
    public function exceptionLogs(): HasMany;

    public function site(): BelongsTo;
}
