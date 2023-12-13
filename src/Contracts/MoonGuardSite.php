<?php

namespace Taecontrol\MoonGuard\Contracts;

use Spatie\Url\Url;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Taecontrol\MoonGuard\ValueObjects\RequestDuration;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property string|int $id
 * @property string $name
 * @property string $api_token
 * @property RequestDuration $max_request_duration_ms
 * @property Url $url
 * @property MoonGuardUptimeCheck $uptimeCheck
 * @property MoonGuardSslCertificateCheck $sslCertificateCheck
 * @property MoonGuardExceptionLog $exceptionLogs
 * @property int $cpu_limit
 * @property int $ram_limit
 * @property int $disk_limit
 * @property bool $monitoring_notification_enabled
 */
interface MoonGuardSite
{
    public function scopeWhereUptimeCheckEnabled(Builder $query): Builder;

    public function scopeWhereSslCertificateCheckEnabled(Builder $query): Builder;

    public function scopeWhereIsNotOnMaintenance(Builder $query): Builder;

    public function uptimeCheck(): HasOne;

    public function sslCertificateCheck(): HasOne;

    public function exceptionLogs(): HasManyThrough;

    public function exceptionLogGroups(): HasMany;

    public function url(): Attribute;

    public function getCpuLimit(): int;

    public function getRamLimit(): int;

    public function getDiskLimit(): int;

    public function getMonitoringNotificationEnabled(): bool;
}
