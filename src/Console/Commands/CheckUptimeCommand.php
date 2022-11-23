<?php

namespace Taecontrol\Larastats\Console\Commands;

use Illuminate\Console\Command;
use Taecontrol\Larastats\Repositories\SiteRepository;

class CheckUptimeCommand extends Command
{
    protected $signature = 'check:uptime';

    protected $description = 'Check uptime for all registered sites';

    public function handle()
    {
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
