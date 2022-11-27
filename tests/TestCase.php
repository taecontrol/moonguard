<?php

namespace Taecontrol\Larastats\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Taecontrol\Larastats\Providers\LarastatsServiceProvider;

class TestCase extends Orchestra
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
