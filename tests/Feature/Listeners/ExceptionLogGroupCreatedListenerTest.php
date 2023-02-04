<?php

namespace Taecontrol\MoonGuard\Tests\Feature\Listeners;

use Taecontrol\MoonGuard\Models\User;
use Taecontrol\MoonGuard\Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Models\ExceptionLogGroup;
use Taecontrol\MoonGuard\Events\ExceptionLogGroupCreatedEvent;
use Taecontrol\MoonGuard\Listeners\ExceptionLogGroupCreatedListener;
use Taecontrol\MoonGuard\Notifications\ExceptionLogGroupNotification;

class ExceptionLogGroupCreatedListenerTest extends TestCase
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
        $instance = new ExceptionLogGroupCreatedListener();

        $exceptionLogGroup = ExceptionLogGroup::factory()->create();
        $event = new ExceptionLogGroupCreatedEvent($exceptionLogGroup);
        $instance->handle($event);

        Notification::assertSentTo($this->users, ExceptionLogGroupNotification::class);
    }
}
