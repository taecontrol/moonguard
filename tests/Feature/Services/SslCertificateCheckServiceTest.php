<?php

namespace Taecontrol\MoonGuard\Tests\Feature\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Event;
use Taecontrol\MoonGuard\Models\Site;
use Taecontrol\MoonGuard\Models\User;
use Taecontrol\MoonGuard\Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Enums\SslCertificateStatus;
use Taecontrol\MoonGuard\Models\SslCertificateCheck;
use Taecontrol\MoonGuard\Services\SslCertificateCheckService;
use Taecontrol\MoonGuard\Events\SslCertificateCheckFailedEvent;
use Taecontrol\MoonGuard\Events\SslCertificateExpiresSoonEvent;
use Taecontrol\MoonGuard\Listeners\SslCertificateCheckFailedListener;
use Taecontrol\MoonGuard\Listeners\SslCertificateExpiresSoonListener;

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

        config(['moonguard.ssl_certificate_check.resend_invalid_certificate_notification_every_minutes' => 5]);

        $site = Site::factory()->create([
            'url' => 'https://localhost',
        ]);

        SslCertificateCheck::factory()->for($site)->create([
            'ssl_error_occurrence_time' => now()->subMinutes(config('moonguard.ssl_certificate_check.resend_invalid_certificate_notification_every_minutes')),
        ]);

        Carbon::setTestNow(now()->addMinutes(config('moonguard.ssl_certificate_check.resend_invalid_certificate_notification_every_minutes')));

        $this->sslCertificateCheckService->check($site);

        Event::assertDispatched(SslCertificateCheckFailedEvent::class);

        Event::assertListening(
            SslCertificateCheckFailedEvent::class,
            SslCertificateCheckFailedListener::class
        );
    }
}
