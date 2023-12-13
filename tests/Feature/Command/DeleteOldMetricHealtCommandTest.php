<?php

namespace Taecontrol\MoonGuard\Tests\Feature\Command;

use Taecontrol\MoonGuard\Tests\TestCase;
use Taecontrol\MoonGuard\Models\SystemMetric;

class DeleteOldMetricHealtCommandTest extends TestCase
{
    /** @test */
    public function test_command_deletes_old_metrics_when_deletion_is_enabled()
    {
        config(['moonguard.metric_deletion.enabled' => true]);
        config(['moonguard.metric_deletion.delete_metrics_older_than_days' => 5]);

        $oldMetric = SystemMetric::factory()->create(['created_at' => now()->subDays(6)]);

        $this->artisan('system-metric:delete')->assertExitCode(0);

        $this->assertDatabaseMissing('system_metrics', ['id' => $oldMetric->id]);

        $this->assertEmpty(SystemMetric::where('created_at', '<', now()->subDays(5))->get());
    }
}
