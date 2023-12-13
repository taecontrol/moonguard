<?php

namespace Taecontrol\MoonGuard\Tests\Feature\Listeners;

use Taecontrol\MoonGuard\Models\User;
use Taecontrol\MoonGuard\Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Models\SystemMetric;
use Taecontrol\MoonGuard\Events\SystemMetricEvent;
use Taecontrol\MoonGuard\Listeners\SystemMetricListener;
use Taecontrol\MoonGuard\Notifications\SystemMetricNotification;

class SystemMetricListenerTest extends TestCase
{
    /** @var Collection<User> */
    protected Collection $users;

    public function setUp(): void
    {
        parent::setUp();

        $this->users = User::factory()->count(2)->create();
    }

    /** @test */
    public function listener_sends_notification_when_a_system_metric_is_created()
    {
        Notification::fake();
        $instance = new SystemMetricListener();

        $systemMetric = SystemMetric::factory()->create();
        $event = new SystemMetricEvent($systemMetric->site, 'resource', 'usage', true);

        $instance->handle($event);

        Notification::assertSentTo($this->users, SystemMetricNotification::class);
    }
}
