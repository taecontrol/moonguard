<?php

namespace Taecontrol\Larastats\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Taecontrol\Larastats\Repositories\SiteRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Taecontrol\Larastats\Repositories\ExceptionLogRepository;
use Taecontrol\Larastats\Contracts\LarastatsExceptionLogGroup;
use Taecontrol\Larastats\Database\Factories\ExceptionLogGroupFactory;

class ExceptionLogGroup extends Model implements LarastatsExceptionLogGroup
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

    protected static function newFactory(): ExceptionLogGroupFactory
    {
        return ExceptionLogGroupFactory::new();
    }
}
