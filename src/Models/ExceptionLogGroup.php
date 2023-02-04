<?php

namespace Taecontrol\MoonGuard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Taecontrol\MoonGuard\Repositories\SiteRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Taecontrol\MoonGuard\Repositories\ExceptionLogRepository;
use Taecontrol\MoonGuard\Contracts\MoonGuardExceptionLogGroup;

class ExceptionLogGroup extends Model implements MoonGuardExceptionLogGroup
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'message',
        'type',
        'file',
        'line',
        'first_seen',
        'last_seen',
    ];

    protected $casts = [
        'first_seen' => 'immutable_datetime',
        'last_seen' => 'immutable_datetime',
    ];

    public function exceptionLogs(): HasMany
    {
        return $this->hasMany(ExceptionLogRepository::resolveModelClass());
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(SiteRepository::resolveModelClass());
    }
}
