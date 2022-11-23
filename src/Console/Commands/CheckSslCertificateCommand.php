<?php

namespace Taecontrol\Larastats\Console\Commands;

use Illuminate\Console\Command;
use Taecontrol\Larastats\Repositories\SiteRepository;

class CheckSslCertificateCommand extends Command
{
    protected $signature = 'check:ssl-certificate';

    protected $description = 'Check Ssl Certificate';

    public function handle()
    {
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
