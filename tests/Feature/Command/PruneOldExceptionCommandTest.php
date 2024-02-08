<?php

namespace Taecontrol\MoonGuard\Tests\Feature\Command;

use Taecontrol\MoonGuard\Tests\TestCase;
use Taecontrol\MoonGuard\Models\ExceptionLogGroup;

class PruneOldExceptionCommandTest extends TestCase
{
    /** @test */
    public function test_old_exceptions_are_prune()
    {
        config(['moonguard.prune_exception.enabled' => true]);
        config(['moonguard.prune_exception.prune_exceptions_older_than_days' => 7]);

        $oldException = ExceptionLogGroup::factory()->create([
            'first_seen' => now()->subDays(8),
        ]);

        $this->artisan('exception:prune')->assertExitCode(0);

        $this->assertDatabaseMissing('exception_log_groups', ['id' => $oldException->id]);

        $this->assertEmpty(ExceptionLogGroup::all());
    }
}
