<?php

namespace Taecontrol\Moonguard\Repositories;

use Taecontrol\Moonguard\Contracts\MoonguardSslCertificateCheck;

class SslCertificateCheckRepository extends ModelRepository
{
    protected static string $contract = MoonguardSslCertificateCheck::class;

    protected static string $modelClassConfigKey = 'moonguard.ssl_certificate_check.model';

    public static function isEnabled(): bool
    {
        return config('moonguard.ssl_certificate_check.enabled');
    }

    public static function resolveModel(): MoonguardSslCertificateCheck
    {
        $modelClass = static::resolveModelClass();

        return new $modelClass();
    }
}
