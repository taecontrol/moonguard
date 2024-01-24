<?php

namespace Taecontrol\MoonGuard\Tests;

use AddSMFieldsOnSitesTable;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\Factory;
use Taecontrol\MoonGuard\Providers\MoonGuardServiceProvider;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Taecontrol\\MoonGuard\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            MoonGuardServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $this->setupMigrations($app);
    }

    protected function setupMigrations($app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        include_once __DIR__ . '/../database/migrations/create_moonguard_tables.php.stub';
        include_once __DIR__ . '/../database/migrations/add_system_monitoring_fields_on_sites_table.php.stub';
        (new \CreateMoonGuardTables)->up();
        (new AddSMFieldsOnSitesTable)->up();
    }
}
