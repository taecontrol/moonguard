<?php

namespace Taecontrol\Moonguard\Collections;

use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Collection;
use Taecontrol\Moonguard\Contracts\MoonguardSite;
use Taecontrol\Moonguard\Services\UptimeCheckService;
use Taecontrol\Moonguard\Exceptions\InvalidPeriodException;
use Taecontrol\Moonguard\Services\SslCertificateCheckService;

class SiteCollection extends Collection
{
    public function checkUptime(): void
    {
        /** @var array<string, Response> $responses */
        $responses = Http::pool(fn (Pool $pool) => $this->map(
            fn (MoonguardSite $site) => $pool->as($site->url)->get($site->url)
        ));

        /** @var UptimeCheckService $uptimeCheckService */
        $uptimeCheckService = app(UptimeCheckService::class);

        $this->each(/**
         * @throws InvalidPeriodException
         */ fn (MoonguardSite $site) => $uptimeCheckService->check($site, $responses[$site->url->__toString()])
        );
    }

    public function checkSslCertificate(): void
    {
        /** @var SslCertificateCheckService $sslCertificateCheckService */
        $sslCertificateCheckService = app(SslCertificateCheckService::class);

        $this->each(fn (MoonguardSite $site) => $sslCertificateCheckService->check($site));
    }
}
