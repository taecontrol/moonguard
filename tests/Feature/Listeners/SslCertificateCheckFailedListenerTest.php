<?php

namespace Taecontrol\MoonGuard\Tests\Feature\Listeners;

use Taecontrol\MoonGuard\Models\User;
use Taecontrol\MoonGuard\Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Models\SslCertificateCheck;
use Taecontrol\MoonGuard\Events\SslCertificateCheckFailedEvent;
use Taecontrol\MoonGuard\Listeners\SslCertificateCheckFailedListener;
use Taecontrol\MoonGuard\Notifications\SslCertificateCheckFailedNotification;

class SslCertificateCheckFailedListenerTest extends TestCase
{
    /** @var Collection<User> */
    protected Collection $users;

    public function setUp(): void
    {
        parent::setUp();

        $this->users = User::factory()->count(2)->create();
    }

    /** @test */
    public function listener_sends_notification_when_ssl_certificate_check_fails()
    {
        Notification::fake();
        $instance = new SslCertificateCheckFailedListener();

        $sslCertificateCheck = SslCertificateCheck::factory()->create();
        $event = new SslCertificateCheckFailedEvent($sslCertificateCheck);
        $instance->handle($event);

        Notification::assertSentTo($this->users, SslCertificateCheckFailedNotification::class);
    }
}
