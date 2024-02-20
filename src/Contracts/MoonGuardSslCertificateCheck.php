<?php

namespace Taecontrol\MoonGuard\Contracts;

use Exception;
use Spatie\Url\Url;
use Spatie\SslCertificate\SslCertificate;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|int $site_id
 * @property Url $url
 * @property string $certificate_check_failure_reason;
 * @property MoonGuardSite $site
 * @property bool $is_enabled
 *
 */
interface MoonGuardSslCertificateCheck
{
    public function site(): BelongsTo;

    public function saveCertificate(SslCertificate $certificate, Url $url): void;

    public function saveError(Exception $exception): void;

    public function certificateIsValid(): bool;

    public function certificateIsInvalid(): bool;

    public function certificateIsAboutToExpire(int $maxDaysToExpire): bool;

    public function isEnabled(): Attribute;

    public function shouldNotifyAboutFailure(): bool;
}
