<?php

namespace Taecontrol\Larastats\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Taecontrol\Larastats\Enums\ExceptionLogStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Taecontrol\Larastats\Contracts\LarastatsExceptionLog;
use Taecontrol\Larastats\Database\Factories\ExceptionLogFactory;
use Taecontrol\Larastats\Repositories\ExceptionLogGroupRepository;
use Taecontrol\Larastats\Repositories\SiteRepository;

class ExceptionLog extends Model implements LarastatsExceptionLog
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
