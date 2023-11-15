<?php

namespace Taecontrol\MoonGuard\Console\Commands;

use Illuminate\Console\Command;
use Taecontrol\MoonGuard\Repositories\ExceptionLogRepository;
use Taecontrol\MoonGuard\Repositories\ExceptionLogGroupRepository;

class DeleteOldExceptionCommand extends Command
{
    protected $signature = 'exception:delete';

    protected $description = 'Delete old exceptions';

    public function handle()
    {
        if (! config('moonguard.exception_deletion.enabled')) {
            $this->info('Exception deletion is disabled. If you want to enable it, check the moonguard config file.');

            return;
        }

        $this->info('Starting deletion of old exceptions...');

        $time = config('moonguard.exception_deletion.delete_exceptions_older_than_minutes');

        $this->info('Old exceptions deleted successfully!');

        $this->deleteOldExceptions($time);
    }

    public function isEnabled(): bool
    {
        return config('moonguard.exception_deletion.enabled');
    }

    public static function getExceptionAge(): int
    {
        return config('moonguard.exception_deletion.delete_exceptions_older_than_minutes');
    }

    public static function deleteOldExceptions(int $time): void
    {
        $exceptions = ExceptionLogGroupRepository::query()
            ->where('first_seen', '<', now()->subMinutes($time));

        $exceptions->delete();
    }
}
