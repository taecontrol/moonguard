<?php

namespace Taecontrol\Moonguard\Models;

use Illuminate\Database\Eloquent\Model;
use Taecontrol\Moonguard\Enums\ExceptionLogStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Taecontrol\Moonguard\Repositories\SiteRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Taecontrol\Moonguard\Contracts\MoonguardExceptionLog;
use Taecontrol\Moonguard\Repositories\ExceptionLogGroupRepository;

class ExceptionLog extends Model implements MoonguardExceptionLog
{
    use HasFactory;

    protected $fillable = [
        'message',
        'type',
        'file',
        'status',
        'trace',
        'request',
        'line',
        'thrown_at',
        'exception_log_group_id',
    ];

    protected $casts = [
        'status' => ExceptionLogStatus::class,
        'trace' => 'array',
        'request' => 'array',
        'thrown_at' => 'immutable_datetime',
    ];

    public function site(): HasOneThrough
    {
        return $this->hasOneThrough(
            SiteRepository::resolveModelClass(),
            ExceptionLogGroupRepository::resolveModelClass()
        );
    }

    public function exceptionLogGroup(): BelongsTo
    {
        return $this->belongsTo(ExceptionLogGroupRepository::resolveModelClass());
    }
}
