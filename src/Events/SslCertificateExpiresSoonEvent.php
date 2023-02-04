<?php

namespace Taecontrol\MoonGuard\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Taecontrol\MoonGuard\Contracts\MoonGuardSslCertificateCheck;

class SslCertificateExpiresSoonEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public MoonGuardSslCertificateCheck $sslCertificateCheck)
    {
    }
}
