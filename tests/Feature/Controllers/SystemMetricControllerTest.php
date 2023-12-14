<?php

namespace Taecontrol\MoonGuard\Tests\Feature\Controllers;

use Illuminate\Http\Request;
use Taecontrol\MoonGuard\Models\Site;
use Taecontrol\MoonGuard\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Taecontrol\MoonGuard\Http\Controllers\SystemMetricsController;

class SystemMetricsControllerTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function testStore()
    {
        $site = Site::factory()->create();

        $controller = new SystemMetricsController();

        $request = new Request([
            'api_token' => $site->api_token,
            'cpuLoad' => 10,
            'memory' => 20,
            'disk' => ['freeSpace' => 1000, 'totalSpace' => 2000],
        ]);

        $response = $controller->store($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(json_encode(['success' => true]), $response->getContent());

        $this->assertDatabaseHas('system_metrics', [
            'cpu_usage' => 10,
            'memory_usage' => 20,
            'disk_usage' => '50.00',
            'site_id' => $site->id,
        ]);
    }
}
