<?php

namespace Taecontrol\Larastats\Models;

use Illuminate\Database\Eloquent\Model;
use Taecontrol\Larastats\Enums\ExceptionLogStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Taecontrol\Larastats\Repositories\SiteRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Taecontrol\Larastats\Contracts\LarastatsExceptionLog;
use Taecontrol\Larastats\Database\Factories\ExceptionLogFactory;
use Taecontrol\Larastats\Repositories\ExceptionLogGroupRepository;

class ExceptionLog extends Model implements LarastatsExceptionLog
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'exception_log_group_id',
        'message',
        'type',
        'file',
        'status',
        'trace',
        'request',
        'line',
        'thrown_at',
    ];

    protected $casts = [
        'status' => ExceptionLogStatus::class,
        'trace' => 'array',
        'request' => 'array',
        'thrown_at' => 'immutable_datetime',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(SiteRepository::resolveModelClass());
    }

    public function exceptionLogGroup(): BelongsTo
    {
        return $this->belongsTo(ExceptionLogGroupRepository::resolveModelClass());
    }

    protected static function newFactory(): ExceptionLogFactory
    {
        return ExceptionLogFactory::new();
    }
}
