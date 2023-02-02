<?php

namespace Taecontrol\Moonguard\Tests\Feature\Collections;

use Mockery\MockInterface;
use Taecontrol\Moonguard\Models\Site;
use Taecontrol\Moonguard\Tests\TestCase;
use Taecontrol\Moonguard\Models\UptimeCheck;
use Taecontrol\Moonguard\Models\SslCertificateCheck;
use Taecontrol\Moonguard\Services\UptimeCheckService;
use Taecontrol\Moonguard\Services\SslCertificateCheckService;

class SiteCollectionTest extends TestCase
{
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

    /** @test */
    public function it_checks_ssl_certificates()
    {
        $this->mock(SslCertificateCheckService::class, function (MockInterface $mock) {
            return $mock->shouldReceive('check')->twice();
        });

        $sites = Site::factory()
            ->count(2)
            ->sequence(fn ($sequence) => ['url' => "https://test{$sequence->index}.com"])
            ->create();

        SslCertificateCheck::factory()->for($sites->first())->create();
        SslCertificateCheck::factory()->for($sites->last())->create();

        $sites->checkSslCertificate();
    }
}
