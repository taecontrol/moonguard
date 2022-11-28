<?php

namespace Taecontrol\Larastats\Collections;

use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Collection;
use Taecontrol\Larastats\Contracts\LarastatsSite;
use Taecontrol\Larastats\Services\UptimeCheckService;
use Taecontrol\Larastats\Exceptions\InvalidPeriodException;
use Taecontrol\Larastats\Services\SslCertificateCheckService;

class SiteCollection extends Collection
{
    public function checkUptime(): void
    {
        /** @var array<string, Response> $responses */
        $responses = Http::pool(fn (Pool $pool) => $this->map(
            fn (LarastatsSite $site) => $pool->as($site->url)->get($site->url)
        ));

        /** @var UptimeCheckService $uptimeCheckService */
        $uptimeCheckService = app(UptimeCheckService::class);

        $this->each(/**
         * @throws InvalidPeriodException
         */ fn (LarastatsSite $site) => $uptimeCheckService->check($site, $responses[$site->url->__toString()])
        );
    }

    public function checkSslCertificate(): void
    {
        /** @var SslCertificateCheckService $sslCertificateCheckService */
        $sslCertificateCheckService = app(SslCertificateCheckService::class);

        $this->each(fn (LarastatsSite $site) => $sslCertificateCheckService->check($site));
    }
}
