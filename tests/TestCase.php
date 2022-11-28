<?php

namespace Taecontrol\Larastats\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Database\Eloquent\Factories\Factory;
use Taecontrol\Larastats\Providers\LarastatsServiceProvider;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Taecontrol\\Larastats\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
          LarastatsServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $migration = include __DIR__.'/../database/migrations/create_larastats_tables.php.stub';

        $migration->up();
    }
}
