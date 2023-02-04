<?php

namespace Taecontrol\MoonGuard\Repositories;

use Taecontrol\MoonGuard\Contracts\MoonGuardSslCertificateCheck;

class SslCertificateCheckRepository extends ModelRepository
{
    protected static string $contract = MoonGuardSslCertificateCheck::class;

    protected static string $modelClassConfigKey = 'moonguard.ssl_certificate_check.model';

    public static function isEnabled(): bool
    {
        return config('moonguard.ssl_certificate_check.enabled');
    }

    public static function resolveModel(): MoonGuardSslCertificateCheck
    {
        $modelClass = static::resolveModelClass();

        return new $modelClass();
    }
}
