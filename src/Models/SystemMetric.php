<?php

namespace Taecontrol\MoonGuard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Taecontrol\MoonGuard\Repositories\SiteRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SystemMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'cpu_usage',
        'memory_usage',
        'disk_usage',
        'site_id',
        'recorded_at'
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(SiteRepository::resolveModelClass());
    }
}
