<?php

namespace Taecontrol\MoonGuard\Tests\Feature\Listeners;

use Taecontrol\MoonGuard\Models\User;
use Taecontrol\MoonGuard\Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Models\UptimeCheck;
use Taecontrol\MoonGuard\ValueObjects\Period;
use Taecontrol\MoonGuard\Events\UptimeCheckRecoveredEvent;
use Taecontrol\MoonGuard\Listeners\UptimeCheckRecoveredListener;
use Taecontrol\MoonGuard\Notifications\UptimeCheckRecoveredNotification;

class UptimeCheckRecoveredListenerTest extends TestCase
{
    /** @var Collection<User> */
    protected Collection $users;

    public function setUp(): void
    {
        parent::setUp();

        $this->users = User::factory()->count(2)->create();
    }

    /** @test */
    public function listener_sends_notification_when_uptime_check_recovers()
    {
        Notification::fake();
        $instance = new UptimeCheckRecoveredListener();
        $period = new Period(now()->subMinutes(10), now()->addMinutes(10));

        $uptimeCheck = UptimeCheck::factory()->create();
        $event = new UptimeCheckRecoveredEvent($uptimeCheck, $period);
        $instance->handle($event);

        Notification::assertSentTo($this->users, UptimeCheckRecoveredNotification::class);
    }
}
