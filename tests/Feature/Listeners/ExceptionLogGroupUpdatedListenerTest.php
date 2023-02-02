<?php

namespace Taecontrol\Moonguard\Tests\Feature\Controllers;

use Taecontrol\Moonguard\Models\User;
use Taecontrol\Moonguard\Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use Taecontrol\Moonguard\Models\ExceptionLogGroup;
use Taecontrol\Moonguard\Events\ExceptionLogGroupUpdatedEvent;
use Taecontrol\Moonguard\Listeners\ExceptionLogGroupUpdatedListener;
use Taecontrol\Moonguard\Notifications\ExceptionLogGroupNotification;

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
