<?php

namespace Taecontrol\MoonGuard\Tests\Feature\Controllers;

use Taecontrol\MoonGuard\Models\Site;
use Taecontrol\MoonGuard\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class SystemMetricsControllerTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function it_stores_system_metrics()
    {
        $this->withoutExceptionHandling();
        $site = Site::factory()->create();

        $diskJson = ['freeSpace' => 1000, 'totalSpace' => 2000];
        $data = [
            'api_token' => $site->api_token,
            'cpuLoad' => 10,
            'memory' => 20,
            'disk' => $diskJson,
        ];

        $this->postJson(route('moonguard.api.hardware'), $data)
            ->assertStatus(200);

        $this->assertDatabaseHas('system_metrics', [
            'cpu_load' => 10,
            'memory_usage' => 20,
            'disk_usage' => json_encode($diskJson),
            'site_id' => $site->id,
        ]);
    }
}
