<?php

namespace Taecontrol\MoonGuard\Tests\Feature\Listeners;

use Taecontrol\MoonGuard\Models\User;
use Taecontrol\MoonGuard\Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Models\UptimeCheck;
use Taecontrol\MoonGuard\ValueObjects\Period;
use Taecontrol\MoonGuard\Events\UptimeCheckFailedEvent;
use Taecontrol\MoonGuard\Listeners\UptimeCheckFailedListener;
use Taecontrol\MoonGuard\Notifications\SlackNotifiable;
use Taecontrol\MoonGuard\Notifications\UptimeCheckFailedNotification;

class UptimeCheckFailedListenerTest extends TestCase
{
    /** @var Collection<User> */
    protected Collection $users;

    public function setUp(): void
    {
        parent::setUp();

        $this->users = User::factory()->count(2)->create();
    }

    /** @test */
    public function listener_sends_notification_when_uptime_check_fails()
    {
        Notification::fake();
        $instance = new UptimeCheckFailedListener();
        $period = new Period(now()->subMinutes(10), now()->addMinutes(10));

        $uptimeCheck = UptimeCheck::factory()->create();
        $event = new UptimeCheckFailedEvent($uptimeCheck, $period);
        $instance->handle($event);

        Notification::assertSentTo($this->users, UptimeCheckFailedNotification::class);
    }

    /** @test */
    public function it_checks_handle_method_to_slack()
    {
        config(['moonguard.notifications.channels' => ['slack']]);

        Notification::fake();

        $instance = new UptimeCheckFailedListener();
        $period = new Period(now()->subMinutes(10), now()->addMinutes(10));

        $uptimeCheck = UptimeCheck::factory()->create();
        $event = new UptimeCheckFailedEvent($uptimeCheck, $period);
        $instance->handle($event);

        Notification::assertSentTo(new SlackNotifiable(), UptimeCheckFailedNotification::class);
    }
}
