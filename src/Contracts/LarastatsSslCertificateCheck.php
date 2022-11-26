<?php

namespace Taecontrol\Larastats\Contracts;

use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\SslCertificate\SslCertificate;
use Spatie\Url\Url;

/**
 * @property string|int $site_id
 * @property Url $url
 * @property string $certificate_check_failure_reason;
 * @property LarastatsSite $site
 * @property bool $is_enabled
 *
 */
interface LarastatsSslCertificateCheck
{
    public function site(): BelongsTo;

    public function saveCertificate(SslCertificate $certificate, Url $url): void;

    public function saveError(Exception $exception): void;

    public function certificateIsValid(): bool;

    public function certificateIsInvalid(): bool;

    public function certificateIsAboutToExpire(int $maxDaysToExpire): bool;

    public function isEnabled(): Attribute;
}
