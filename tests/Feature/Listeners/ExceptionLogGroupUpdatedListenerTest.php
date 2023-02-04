<?php

namespace Taecontrol\MoonGuard\Tests\Feature\Listeners;

use Taecontrol\MoonGuard\Models\User;
use Taecontrol\MoonGuard\Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Models\ExceptionLogGroup;
use Taecontrol\MoonGuard\Events\ExceptionLogGroupUpdatedEvent;
use Taecontrol\MoonGuard\Listeners\ExceptionLogGroupUpdatedListener;
use Taecontrol\MoonGuard\Notifications\ExceptionLogGroupNotification;

class ExceptionLogGroupUpdatedListenerTest extends TestCase
{
    /** @var Collection<User> */
    protected Collection $users;

    public function setUp(): void
    {
        parent::setUp();

        $this->users = User::factory()->count(2)->create();
    }

    /** @test */
    public function listener_sends_notification_when_an_exception_log_group_is_created()
    {
        Notification::fake();
        $instance = new ExceptionLogGroupUpdatedListener();

        $exceptionLogGroup = ExceptionLogGroup::factory()->create();
        $event = new ExceptionLogGroupUpdatedEvent($exceptionLogGroup);
        $instance->handle($event);

        Notification::assertSentTo($this->users, ExceptionLogGroupNotification::class);
    }
}
