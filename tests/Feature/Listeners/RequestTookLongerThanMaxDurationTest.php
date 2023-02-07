<?php

namespace Taecontrol\MoonGuard\Tests\Feature\Listeners;

use Taecontrol\MoonGuard\Models\User;
use Taecontrol\MoonGuard\Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Models\UptimeCheck;
use Taecontrol\MoonGuard\ValueObjects\RequestDuration;
use Taecontrol\MoonGuard\Events\RequestTookLongerThanMaxDurationEvent;
use Taecontrol\MoonGuard\Listeners\RequestTookLongerThanMaxDurationListener;
use Taecontrol\MoonGuard\Notifications\RequestTookLongerThanMaxDurationNotification;

class RequestTookLongerThanMaxDurationTest extends TestCase
{
    /** @var Collection<User> */
    protected Collection $users;

    public function setUp(): void
    {
        parent::setUp();

        $this->users = User::factory()->count(2)->create();
    }

    /** @test */
    public function listener_sends_notification_when_a_request_took_longer_than_max_duration()
    {
        Notification::fake();
        $instance = new RequestTookLongerThanMaxDurationListener();
        $maxRequestDuration = RequestDuration::from(1000);

        $uptimeCheck = UptimeCheck::factory()->create();
        $event = new RequestTookLongerThanMaxDurationEvent($uptimeCheck, $maxRequestDuration);
        $instance->handle($event);

        Notification::assertSentTo($this->users, RequestTookLongerThanMaxDurationNotification::class);
    }
}
