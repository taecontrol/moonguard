<?php

namespace Taecontrol\MoonGuard\Tests\Feature\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Taecontrol\MoonGuard\Models\Site;
use Taecontrol\MoonGuard\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Taecontrol\MoonGuard\Http\Controllers\SystemMetricsController;

class SystemMetricsControllerTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function store_creates_a_new_system_metric()
    {
        $site = Site::factory()->create();
        $request = Request::create('/store', 'POST', [
            'api_token' => $site->api_token,
            'cpuLoad' => 50,
            'memory' => 100,
            'disk' => ['freeSpace' => 1000, 'totalSpace' => 2000],
        ]);

        $controller = new SystemMetricsController();
        $response = $controller->store($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('system_metrics', [
            'cpu_usage' => 50,
            'memory_usage' => 100,
            'disk_usage' => json_encode(['freeSpace' => 1000, 'totalSpace' => 2000]),
            'site_id' => $site->id,
        ]);
    }
}
