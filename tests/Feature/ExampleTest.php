<?php

namespace Taecontrol\Larastats\Tests\Feature;

use Taecontrol\Larastats\Models\Site;
use Taecontrol\Larastats\Tests\TestCase;
use Taecontrol\Larastats\Models\UptimeCheck;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Taecontrol\Larastats\Database\Factories\UptimeCheckFactory;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_assert_that_true_is_true()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function it_can_use_factories()
    {
        $this->withoutExceptionHandling();
        /** @var Site */
        $site = Site::factory()->create();
        $uptimeCheckFactory = UptimeCheck::factory()
            ->create([
                'site_id', $site->id
            ]);

        $this->assertNotNull($uptimeCheckFactory);
        $this->assertNotNull($site);
        $this->assertDatabaseCount('sites', 1);
        $this->assertDatabaseHas('sites', ['name' => $site->name]);
    }
}
