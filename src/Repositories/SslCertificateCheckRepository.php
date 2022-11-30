<?php

namespace Taecontrol\Larastats\Repositories;

use Taecontrol\Larastats\Models\SslCertificateCheck;
use Taecontrol\Larastats\Contracts\LarastatsSslCertificateCheck;

class SslCertificateCheckRepository extends ModelRepository
{
    protected static string $contract = LarastatsSslCertificateCheck::class;

    protected static string $modelClassConfigKey = 'larastats.ssl_certificate_check.model';

    public static function isEnabled(): bool
    {
        return config('larastats.ssl_certificate_check.enabled');
    }

    public static function resolveModel(): LarastatsSslCertificateCheck
    {
        $modelClass = static::resolveModelClass();

        return new $modelClass();
    }
}
