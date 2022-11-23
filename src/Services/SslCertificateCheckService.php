<?php

namespace Taecontrol\Larastats\Services;

use Exception;
use Spatie\SslCertificate\SslCertificate;
use Illuminate\Support\Facades\Notification;
use Taecontrol\Larastats\Contracts\LarastatsSite;
use Taecontrol\Larastats\Contracts\LarastatsSslCertificateCheck;
use Taecontrol\Larastats\Notifications\SslCertificateCheckFailedNotification;
use Taecontrol\Larastats\Notifications\SslCertificateExpiresSoonNotification;
use Taecontrol\Larastats\Repositories\SslCertificateCheckRepository;
use Taecontrol\Larastats\Repositories\UserRepository;

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
            Notification::send(UserRepository::all(), new SslCertificateExpiresSoonNotification($this->sslCertificateCheck));
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
        Notification::send(UserRepository::all(), new SslCertificateCheckFailedNotification($this->sslCertificateCheck));
    }
}
