<?php

namespace Taecontrol\Larastats\Console\Commands;

use Illuminate\Console\Command;
use Taecontrol\Larastats\Repositories\SiteRepository;
use Taecontrol\Larastats\Repositories\UptimeCheckRepository;

class CheckUptimeCommand extends Command
{
    protected $signature = 'check:uptime';

    protected $description = 'Check uptime for all registered sites';

    public function handle()
    {
        if (! UptimeCheckRepository::isEnabled()) {
            $this->info('[Uptime] This check is disabled. If you want to enable it, check the larastats config file.');

            return;
        }

        $this->info('[Uptime] Starting check...');

        SiteRepository::query()
            ->whereUptimeCheckEnabled()
            ->whereIsNotOnMaintenance()
            ->with('uptimeCheck')
            ->get()
            ->checkUptime();

        $this->info('[Uptime] Uptime checked');
    }
}
