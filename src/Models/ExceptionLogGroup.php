<?php

namespace Taecontrol\Moonguard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Taecontrol\Moonguard\Repositories\SiteRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Taecontrol\Moonguard\Repositories\ExceptionLogRepository;
use Taecontrol\Moonguard\Contracts\MoonguardExceptionLogGroup;

class ExceptionLogGroup extends Model implements MoonguardExceptionLogGroup
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
