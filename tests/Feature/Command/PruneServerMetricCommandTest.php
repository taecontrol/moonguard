<?php

namespace Taecontrol\MoonGuard\Tests\Feature\Command;

use Taecontrol\MoonGuard\Tests\TestCase;
use Taecontrol\MoonGuard\Models\ServerMetric;

class PruneServerMetricCommandTest extends TestCase
{
    /** @test */
    public function command_prune_metrics_when_deletion_is_enabled()
    {
        config(['moonguard.server_monitoring_records_prune.enabled' => true]);
        config(['moonguard.server_monitoring_records_prune.prune_server_monitoring_records_older_than_days' => 7]);

        $oldMetric = ServerMetric::factory()->create(['created_at' => now()->subDays(8)]);

        $this->artisan('server-metric:prune')->assertExitCode(0);

        $this->assertDatabaseMissing('server_metrics', ['id' => $oldMetric->id]);

        $this->assertEmpty(ServerMetric::where('created_at', '<', now()->subDays(5))->get());
    }
}
