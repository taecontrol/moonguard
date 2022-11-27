<?php

namespace Taecontrol\Tests;

use Taecontrol\Larastats\Providers\LarastatsServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
          LarastatsServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
    }
}
