<?php

namespace Taecontrol\MoonGuard\Tests\Feature\Command;

use Taecontrol\MoonGuard\Tests\TestCase;
use Taecontrol\MoonGuard\Models\ExceptionLogGroup;

class DeleteOldExceptionCommandTest extends TestCase
{
    /** @test */
    public function test_old_exceptions_are_deleted()
    {
        config(['moonguard.exception_deletion.enabled' => true]);
        config(['moonguard.exception_deletion.delete_exceptions_older_than_days' => 7]);

        $oldException = ExceptionLogGroup::factory()->create([
            'first_seen' => now()->subDays(8),
        ]);

        $this->artisan('exception:delete')->assertExitCode(0);

        $this->assertDatabaseMissing('exception_log_groups', ['id' => $oldException->id]);

        $this->assertEmpty(ExceptionLogGroup::all());
    }
}
