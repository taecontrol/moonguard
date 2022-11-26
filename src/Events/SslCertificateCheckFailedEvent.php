<?php

namespace Taecontrol\Larastats\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Taecontrol\Larastats\Contracts\LarastatsSslCertificateCheck;

class SslCertificateCheckFailedEvent
{
    use Dispatchable, SerializesModels;

    public function __construct(public LarastatsSslCertificateCheck $sslCertificateCheck)
    {}
}