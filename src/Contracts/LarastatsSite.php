<?php

namespace Taecontrol\Larastats\Contracts;

use Spatie\Url\Url;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Taecontrol\Larastats\ValueObjects\RequestDuration;

/**
 * @property string|int $id
 * @property string $name
 * @property RequestDuration $max_request_duration_ms
 * @property Url $url
 * @property LarastatsUptimeCheck $uptimeCheck
 * @property LarastatsSslCertificateCheck $sslCertificateCheck
 * @property LarastatsExceptionLog $exceptionLogs
 */
interface LarastatsSite
{
    public function scopeWhereUptimeCheckEnabled(Builder $query): Builder;

    public function scopeWhereSslCertificateCheckEnabled(Builder $query): Builder;

    public function scopeWhereIsNotOnMaintenance(Builder $query): Builder;

    public function uptimeCheck(): HasOne;

    public function sslCertificateCheck(): HasOne;

    public function exceptionLogs(): HasMany;

    public function exceptionLogsGroup(): HasMany;

    public function url(): Attribute;
}
