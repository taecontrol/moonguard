<?php

namespace Taecontrol\MoonGuard\Console\Commands;

use Illuminate\Console\Command;
use Taecontrol\MoonGuard\Repositories\SiteRepository;
use Taecontrol\MoonGuard\Repositories\SslCertificateCheckRepository;

class CheckSslCertificateCommand extends Command
{
    protected $signature = 'check:ssl-certificate';

    protected $description = 'Check Ssl Certificate';

    public function handle()
    {
        if (! SslCertificateCheckRepository::isEnabled()) {
            $this->info('[SSL] This check is disabled. If you want to enable it, check the moonguard config file.');

            return;
        }

        $this->info('[SSL] Starting check...');

        SiteRepository::query()
            ->whereSslCertificateCheckEnabled()
            ->whereIsNotOnMaintenance()
            ->with('sslCertificateCheck')
            ->get()
            ->checkSslCertificate();

        $this->info('[SSL] SSL certificates checked');
    }
}
