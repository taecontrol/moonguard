<?php

namespace Taecontrol\MoonGuard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Taecontrol\MoonGuard\Repositories\SiteRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Taecontrol\MoonGuard\Database\Factories\SystemMetricFactory;

class SystemMetric extends Model
{
    use HasFactory;

    const CREATED_AT = 'created_at';

    protected $fillable = [
        'cpu_usage',
        'memory_usage',
        'disk_usage',
        'disk_usage_percentage',
        'site_id',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(SiteRepository::resolveModelClass());
    }

    protected static function newFactory(): Factory
    {
        return SystemMetricFactory::new();
    }
}
