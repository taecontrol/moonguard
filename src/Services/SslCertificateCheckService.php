<?php

namespace Taecontrol\Larastats\Services;

use Exception;
use Spatie\SslCertificate\SslCertificate;
use Taecontrol\Larastats\Contracts\LarastatsSite;
use Taecontrol\Larastats\Events\SslCertificateCheckFailedEvent;
use Taecontrol\Larastats\Events\SslCertificateExpiresSoonEvent;
use Taecontrol\Larastats\Contracts\LarastatsSslCertificateCheck;
use Taecontrol\Larastats\Repositories\SslCertificateCheckRepository;

class SslCertificateCheckService
{
    protected LarastatsSslCertificateCheck $sslCertificateCheck;

    public function check(LarastatsSite $site): void
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
        if (
            $this->sslCertificateCheck->certificateIsValid()
            && $this->sslCertificateCheck->certificateIsAboutToExpire(config('larastats.ssl_certificate_check.notify_expiring_soon_if_certificate_expires_within_days'))
        ) {
            event(new SslCertificateExpiresSoonEvent($this->sslCertificateCheck));
        }

        if ($this->sslCertificateCheck->certificateIsInvalid()) {
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

    protected function notifyFailure(): void
    {
        event(new SslCertificateCheckFailedEvent($this->sslCertificateCheck));
    }
}
