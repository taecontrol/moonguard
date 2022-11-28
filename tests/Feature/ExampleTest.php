<?php

namespace Taecontrol\Larastats\Tests\Feature;

use Taecontrol\Larastats\Models\Site;
use Taecontrol\Larastats\Tests\TestCase;
use Taecontrol\Larastats\Models\UptimeCheck;

class ExampleTest extends TestCase
{
    /** @test */
    public function it_assert_that_true_is_true()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function test_can_use_factories()
    {
        /** @var Site */
        $site = Site::factory()->create();

        $this->assertNotNull($site);
        $this->assertDatabaseCount('sites', 1);
        $this->assertDatabaseHas('sites', ['name' => $site->name]);
    }

    /** @test */
    public function test_can_use_factories_with_relationships()
    {
        /** @var Site */
        $site = Site::factory()->create();

        /** @var UptimeCheck */
        $uptimeCheckFactory = UptimeCheck::factory()
            ->create([
                'site_id' => $site->id,
            ]);

        $this->assertNotNull($uptimeCheckFactory);
        $this->assertNotNull($site);
        $this->assertDatabaseCount('sites', 1);
        $this->assertDatabaseCount('uptime_checks', 1);
        $this->assertDatabaseHas('sites', ['name' => $site->name]);
    }
}
