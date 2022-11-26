<?php

namespace Taecontrol\Larastats\Models;

use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\SslCertificate\SslCertificate;
use Spatie\Url\Url;
use Taecontrol\Larastats\Contracts\LarastatsSslCertificateCheck;
use Taecontrol\Larastats\Enums\SslCertificateStatus;
use Taecontrol\Larastats\Repositories\SiteRepository;
use Taecontrol\Larastats\Repositories\SslCertificateCheckRepository;

class SslCertificateCheck extends Model implements LarastatsSslCertificateCheck
{
    protected $casts = [
        'status' => SslCertificateStatus::class,
        'expiration_date' => 'immutable_datetime',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(SiteRepository::resolveModelClass());
    }

    public function saveCertificate(SslCertificate $certificate, Url $url): void
    {
        $this->status = $certificate->isValid($url)
            ? SslCertificateStatus::VALID
            : SslCertificateStatus::INVALID;

        $this->expiration_date = $certificate->expirationDate();
        $this->issuer = $certificate->getIssuer();
        $this->check_failure_reason = null;

        $this->save();
    }

    public function saveError(Exception $exception): void
    {
        $this->status = SslCertificateStatus::INVALID;
        $this->expiration_date = null;
        $this->issuer = '';
        $this->check_failure_reason = $exception->getMessage();

        $this->save();
    }

    public function certificateIsValid(): bool
    {
        return $this->status === SslCertificateStatus::VALID;
    }

    public function certificateIsInvalid(): bool
    {
        return $this->status === SslCertificateStatus::INVALID;
    }

    public function certificateIsAboutToExpire(int $maxDaysToExpire): bool
    {
        return $this->expiration_date?->diffInDays() <= $maxDaysToExpire;
    }

    public function isEnabled(): Attribute
    {
        return Attribute::make(
            get: fn () => SslCertificateCheckRepository::isEnabled(),
        );
    }
}
