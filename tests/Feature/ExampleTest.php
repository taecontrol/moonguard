<?php

namespace Taecontrol\Larastats\Tests\Feature;

use Taecontrol\Larastats\Models\Site;
use Taecontrol\Larastats\Tests\TestCase;

class ExampleTest extends TestCase
{
    /** @test */
    public function it_assert_that_true_is_true()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function it_can_use_factories()
    {
        /** @var Site */
        $site = Site::factory()->create();

        $this->assertNotNull($site);
        $this->assertDatabaseCount('sites', 1);
        $this->assertDatabaseHas('sites', ['name' => $site->name]);
    }
}
