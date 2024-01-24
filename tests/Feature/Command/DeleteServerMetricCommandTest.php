<?php

namespace Taecontrol\MoonGuard\Tests\Feature\Command;

use Taecontrol\MoonGuard\Tests\TestCase;
use Taecontrol\MoonGuard\Models\ServerMetric;

class DeleteServerMetricCommandTest extends TestCase
{
    /** @test */
    public function command_deletes_metrics_when_deletion_is_enabled()
    {
        config(['moonguard.system_monitoring_records_deletion.enabled' => true]);
        config(['moonguard.system_monitoring_records_deletion.delete_system_monitoring_records_older_than_days' => 7]);

        $oldMetric = ServerMetric::factory()->create(['created_at' => now()->subDays(8)]);

        $this->artisan('server-metric:delete')->assertExitCode(0);

        $this->assertDatabaseMissing('server_metrics', ['id' => $oldMetric->id]);

        $this->assertEmpty(ServerMetric::where('created_at', '<', now()->subDays(5))->get());
    }
}
