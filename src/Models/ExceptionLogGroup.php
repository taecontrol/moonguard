<?php

namespace Taecontrol\Larastats\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Taecontrol\Larastats\Contracts\LarastatsExceptionLogGroup;
use Taecontrol\Larastats\Repositories\ExceptionLogRepository;
use Taecontrol\Larastats\Repositories\SiteRepository;

class ExceptionLogGroup extends Model implements LarastatsExceptionLogGroup
{
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
