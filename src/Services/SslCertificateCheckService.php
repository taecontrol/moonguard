<?php

namespace Taecontrol\MoonGuard\Services;

use Exception;
use Illuminate\Support\Facades\Cache;
use Spatie\SslCertificate\SslCertificate;
use Taecontrol\MoonGuard\Contracts\MoonGuardSite;
use Taecontrol\MoonGuard\Events\SslCertificateCheckFailedEvent;
use Taecontrol\MoonGuard\Events\SslCertificateExpiresSoonEvent;
use Taecontrol\MoonGuard\Contracts\MoonGuardSslCertificateCheck;
use Taecontrol\MoonGuard\Repositories\SslCertificateCheckRepository;

class SslCertificateCheckService
{
    protected MoonGuardSslCertificateCheck $sslCertificateCheck;

    public function check(MoonGuardSite $site): void
    {
        if (! $site->sslCertificateCheck) {
            $this->sslCertificateCheck = SslCertificateCheckRepository::resolveModel();
            $this->sslCertificateCheck->site_id = $site->id;
        } else {
            $this->sslCertificateCheck = $site->sslCertificateCheck;
        }

        try {
            $certificate = SslCertificate::createForHostName($site->url->getHost());
            $this->sslCertificateCheck->saveCertificate($certificate, $site->url);
            $this->notifyAfterSavingCertificate($certificate);
        } catch (Exception $exception) {
            $this->sslCertificateCheck->saveError($exception);
            $this->notifyFailure();
        }
    }

    protected function notifyAfterSavingCertificate(SslCertificate $certificate): void
    {
        $maxDaysToExpireFromConfig = config('moonguard.ssl_certificate_check.notify_expiring_soon_if_certificate_expires_within_days');

        $isCertificateValidAndAboutToExpire = $this->sslCertificateCheck->certificateIsValid()
            && $this->sslCertificateCheck->certificateIsAboutToExpire($maxDaysToExpireFromConfig);

        $isCertificateInvalid = $this->sslCertificateCheck->certificateIsInvalid();

        if ($isCertificateValidAndAboutToExpire) {
            event(new SslCertificateExpiresSoonEvent($this->sslCertificateCheck));
        }

        if ($isCertificateInvalid) {
            $reason = 'Unknown';

            if (! $certificate->appliesToUrl($this->sslCertificateCheck->url)) {
                $reason = "Certificate does not apply to {$this->sslCertificateCheck->url} but only to these domains: " . implode(',', $certificate->getAdditionalDomains());
            }

            if ($certificate->isExpired()) {
                $reason = 'The certificate has expired';
            }

            $this->sslCertificateCheck->certificate_check_failure_reason = $reason;
            $this->sslCertificateCheck->save();

            $this->notifyFailure();
        }
    }

    protected function shouldNotifyFailure(): bool
    {
        $sslErrorOccurrenceTime = Cache::get('ssl_error_occurrence_time');

        $resendNotificationMinutes = config('moonguard.ssl_certificate_check.resend_invalid_certificate_notification_every_minutes');

        return $sslErrorOccurrenceTime !== null && now()->diffInMinutes($sslErrorOccurrenceTime) >= $resendNotificationMinutes;
    }

    protected function notifyFailure(): void
    {
        if ($this->shouldNotifyFailure()) {
            event(new SslCertificateCheckFailedEvent($this->sslCertificateCheck));

            Cache::put('ssl_error_occurrence_time', now());
        }
    }
}
