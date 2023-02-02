<?php

namespace Taecontrol\Moonguard\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Taecontrol\Moonguard\Contracts\MoonguardSslCertificateCheck;

class SslCertificateExpiresSoonEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public MoonguardSslCertificateCheck $sslCertificateCheck)
    {
    }
}
