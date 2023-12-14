<?php

namespace Taecontrol\MoonGuard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'site_id',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(SiteRepository::resolveModelClass());
    }

    public function diskUsage(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                $diskUsage = json_decode($value, true);
                $freeSpace = $diskUsage['freeSpace'] ?? null;
                $totalSpace = $diskUsage['totalSpace'] ?? null;

                $diskPercentage = $totalSpace ? ($totalSpace - $freeSpace) / $totalSpace * 100 : 0;

                return number_format($diskPercentage, 2);
            }
        );
    }

    protected static function newFactory(): Factory
    {
        return SystemMetricFactory::new();
    }
}
