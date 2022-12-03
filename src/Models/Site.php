<?php

namespace Taecontrol\Larastats\Models;

use Spatie\Url\Url;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Taecontrol\Larastats\Contracts\LarastatsSite;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Taecontrol\Larastats\Casts\RequestDurationCast;
use Taecontrol\Larastats\Collections\SiteCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Taecontrol\Larastats\Repositories\UptimeCheckRepository;
use Taecontrol\Larastats\Repositories\ExceptionLogRepository;
use Taecontrol\Larastats\Repositories\ExceptionLogGroupRepository;
use Taecontrol\Larastats\Repositories\SslCertificateCheckRepository;

class Site extends Model implements LarastatsSite
{
    use HasFactory;

    protected $fillable = [
        'url',
        'name',
        'uptime_check_enabled',
        'ssl_certificate_check_enabled',
        'max_request_duration_ms',
        'down_for_maintenance_at',
        'api_token',
    ];

    protected $casts = [
        'max_request_duration_ms' => RequestDurationCast::class,
        'down_for_maintenance_at' => 'immutable_datetime',
        'uptime_check_enabled' => 'boolean',
        'ssl_certificate_check_enabled' => 'boolean',
    ];

    public function scopeWhereUptimeCheckEnabled(Builder $query): Builder
    {
        return $query->where('uptime_check_enabled', true);
    }

    public function scopeWhereSslCertificateCheckEnabled(Builder $query): Builder
    {
        return $query->where('ssl_certificate_check_enabled', true);
    }

    public function scopeWhereIsNotOnMaintenance(Builder $query): Builder
    {
        return $query->whereNull('down_for_maintenance_at');
    }

    public function url(): Attribute
    {
        return Attribute::make(
            get: fn () => Url::fromString($this->attributes['url']),
        );
    }

    public function uptimeCheck(): HasOne
    {
        return $this->hasOne(UptimeCheckRepository::resolveModelClass());
    }

    public function sslCertificateCheck(): HasOne
    {
        return $this->hasOne(SslCertificateCheckRepository::resolveModelClass());
    }

    public function exceptionLogs(): HasManyThrough
    {
        return $this->hasManyThrough(
            ExceptionLogRepository::resolveModelClass(),
            ExceptionLogGroupRepository::resolveModelClass()
        );
    }

    public function exceptionLogGroups(): HasMany
    {
        return $this->hasMany(ExceptionLogGroupRepository::resolveModelClass());
    }

    public function newCollection(array $models = []): SiteCollection
    {
        return new SiteCollection($models);
    }
}
