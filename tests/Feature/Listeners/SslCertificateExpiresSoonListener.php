<?php

namespace Taecontrol\MoonGuard\Tests\Feature\Listeners;

use Taecontrol\MoonGuard\Models\User;
use Taecontrol\MoonGuard\Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Models\SslCertificateCheck;
use Taecontrol\MoonGuard\Events\SslCertificateExpiresSoonEvent;
use Taecontrol\MoonGuard\Listeners\SslCertificateExpiresSoonListener;
use Taecontrol\MoonGuard\Notifications\SslCertificateExpiresSoonNotification;

class SslCertificateExpiresSoonListenerTest extends TestCase
{
    /** @var Collection<User> */
    protected Collection $users;

    public function setUp(): void
    {
        parent::setUp();

        $this->users = User::factory()->count(2)->create();
    }

    /** @test */
    public function listener_sends_notification_when_ssl_certificate_expires_soon()
    {
        Notification::fake();
        $instance = new SslCertificateExpiresSoonListener();

        $sslCertificateCheck = SslCertificateCheck::factory()->create();
        $event = new SslCertificateExpiresSoonEvent($sslCertificateCheck);
        $instance->handle($event);

        Notification::assertSentTo($this->users, SslCertificateExpiresSoonNotification::class);
    }
}
