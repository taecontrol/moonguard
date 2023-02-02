<?php

namespace Taecontrol\Moonguard\Tests\Feature\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Event;
use Taecontrol\Moonguard\Models\Site;
use Taecontrol\Moonguard\Models\User;
use Taecontrol\Moonguard\Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use Taecontrol\Moonguard\Enums\SslCertificateStatus;
use Taecontrol\Moonguard\Models\SslCertificateCheck;
use Taecontrol\Moonguard\Services\SslCertificateCheckService;
use Taecontrol\Moonguard\Events\SslCertificateCheckFailedEvent;
use Taecontrol\Moonguard\Events\SslCertificateExpiresSoonEvent;
use Taecontrol\Moonguard\Listeners\SslCertificateCheckFailedListener;
use Taecontrol\Moonguard\Listeners\SslCertificateExpiresSoonListener;

class SslCertificateCheckServiceTest extends TestCase
{
    /** @var Collection<User> */
    protected Collection $users;

    protected SslCertificateCheckService $sslCertificateCheckService;

    public function setUp(): void
    {
        parent::setUp();

        $this->users = User::factory()->count(2)->create();

        $this->sslCertificateCheckService = app(SslCertificateCheckService::class);
    }

    /** @test */
    public function it_checks_ssl_certificates()
    {
        Http::fake();
        Notification::fake();

        $this->freezeTime();

        $site = Site::factory()->create([
            'url' => 'https://google.com',
        ]);

        SslCertificateCheck::factory()->for($site)->create();

        $this->sslCertificateCheckService->check($site);

        $sslCertificateCheck = $site->sslCertificateCheck()->first();

        $this->assertSame(SslCertificateStatus::VALID, $sslCertificateCheck->status);

        Notification::assertNothingSent();
    }

    /** @test */
    public function it_checks_if_ssl_certificates_is_about_to_expire()
    {
        Http::fake();
        Event::fake();

        config()->set('moonguard.ssl_certificate_check.notify_expiring_soon_if_certificate_expires_within_days', 100000);

        $site = Site::factory()->create([
            'url' => 'https://google.com',
        ]);

        SslCertificateCheck::factory()->for($site)->create();

        $this->sslCertificateCheckService->check($site);

        Event::assertDispatched(SslCertificateExpiresSoonEvent::class);

        Event::assertListening(
            SslCertificateExpiresSoonEvent::class,
            SslCertificateExpiresSoonListener::class
        );
    }

    /** @test */
    public function it_notifies_if_the_certificate_is_invalid()
    {
        Http::fake();
        Event::fake();

        $site = Site::factory()->create([
            'url' => 'https://localhost',
        ]);

        SslCertificateCheck::factory()->for($site)->create();

        $this->sslCertificateCheckService->check($site);

        Event::assertDispatched(SslCertificateCheckFailedEvent::class);

        Event::assertListening(
            SslCertificateCheckFailedEvent::class,
            SslCertificateCheckFailedListener::class
        );
    }
}
