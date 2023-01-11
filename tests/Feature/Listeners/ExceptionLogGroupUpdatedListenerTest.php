<?php

namespace Taecontrol\Larastats\Tests\Feature\Controllers;

use Taecontrol\Larastats\Models\User;
use Taecontrol\Larastats\Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use Taecontrol\Larastats\Models\ExceptionLogGroup;
use Taecontrol\Larastats\Events\ExceptionLogGroupUpdatedEvent;
use Taecontrol\Larastats\Listeners\ExceptionLogGroupUpdatedListener;
use Taecontrol\Larastats\Notifications\ExceptionLogGroupNotification;

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
