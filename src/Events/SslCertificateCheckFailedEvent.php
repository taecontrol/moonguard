<?php

namespace Taecontrol\Larastats\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Taecontrol\Larastats\Contracts\LarastatsSslCertificateCheck;

class SslCertificateCheckFailedEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public LarastatsSslCertificateCheck $sslCertificateCheck)
    {
    }
}
