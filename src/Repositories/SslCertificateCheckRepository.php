<?php

namespace Taecontrol\Larastats\Repositories;

use Taecontrol\Larastats\Contracts\LarastatsSslCertificateCheck;
use Taecontrol\Larastats\Models\SslCertificateCheck;

class SslCertificateCheckRepository
{
    public static function isEnabled(): bool
    {
        return config('larastats.ssl_certificate_check.enabled');
    }

    public static function resolveModel(): LarastatsSslCertificateCheck
    {
        $modelClass = static::resolveModelClass();

        return new $modelClass();
    }

    public static function resolveModelClass(): string
    {
        return config('larastats.ssl_certificate_check.model') ?? SslCertificateCheck::class;
    }
}
