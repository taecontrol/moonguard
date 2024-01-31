<?php

namespace Taecontrol\MoonGuard\Console\Commands;

use Illuminate\Console\Command;
use Taecontrol\MoonGuard\Repositories\ExceptionLogGroupRepository;

class PruneExceptionCommand extends Command
{
    protected $signature = 'exception:prune';

    protected $description = 'Prune old exceptions';

    public function handle()
    {
        if (! $this->isEnabled()) {
            $this->info('Exception prune is disabled. If you want to enable it, check the moonguard config file.');

            return;
        }

        $this->info('Starting prune of old exceptions...');

        $time = $this->getExceptionAge();

        $this->info('Old exceptions prune successfully!');

        $this->pruneOldExceptions($time);
    }

    public function isEnabled(): bool
    {
        return config('moonguard.prune_exception.enabled');
    }

    public static function getExceptionAge(): int
    {
        return config('moonguard.prune_exception.prune_exceptions_older_than_days');
    }

    public static function pruneOldExceptions(int $time): void
    {
        $exceptions = ExceptionLogGroupRepository::query()
            ->where('first_seen', '<', now()->subDays($time));

        $exceptions->delete();
    }
}
