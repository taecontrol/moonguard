<?php

namespace Core\tests\Feature\Collections;

use Mockery\MockInterface;
use Taecontrol\Tests\TestCase;
use Taecontrol\Larastats\Models\Site;
use Taecontrol\Larastats\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Taecontrol\Larastats\Models\UptimeCheck;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Taecontrol\Larastats\Models\SslCertificateCheck;
use Taecontrol\Larastats\Services\UptimeCheckService;
use Taecontrol\Larastats\Services\SslCertificateCheckService;

class SiteCollectionTest extends TestCase
{
    use RefreshDatabase;

    /** @var Collection<User> */
    protected Collection $users;

    public function setUp(): void
    {
        parent::setUp();

        $this->users = User::factory()->count(2)->create();
    }

    /** @test */
    public function it_checks_uptime()
    {
        $this->mock(UptimeCheckService::class, function (MockInterface $mock) {
            return $mock->shouldReceive('check')->twice();
        });

        $sites = Site::factory()
            ->count(2)
            ->sequence(fn ($sequence) => ['url' => "https://test{$sequence->index}.com"])
            ->create();

        UptimeCheck::factory()->for($sites->first())->create();
        UptimeCheck::factory()->for($sites->last())->create();

        $sites->checkUptime();
    }

    // /** @test */
    // public function it_checks_ssl_certificates()
    // {
    //     $this->mock(SslCertificateCheckService::class, function (MockInterface $mock) {
    //         return $mock->shouldReceive('check')->twice();
    //     });

    //     $sites = Site::factory()
    //         ->count(2)
    //         ->sequence(fn ($sequence) => ['url' => "https://test{$sequence->index}.com"])
    //         ->create();

    //     SslCertificateCheck::factory()->for($sites->first())->create();
    //     SslCertificateCheck::factory()->for($sites->last())->create();

    //     $sites->checkSslCertificate();
    // }
}
