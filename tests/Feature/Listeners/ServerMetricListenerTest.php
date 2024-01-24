<?php

namespace Taecontrol\MoonGuard\Tests\Feature\Listeners;

use Taecontrol\MoonGuard\Models\User;
use Taecontrol\MoonGuard\Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Models\ServerMetric;
use Taecontrol\MoonGuard\Events\ServerMetricAlertEvent;
use Taecontrol\MoonGuard\Listeners\ServerMetricAlertListener;
use Taecontrol\MoonGuard\Notifications\ServerMetricNotification;

class ServerMetricAlertListenerTest extends TestCase
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
        $instance = new ServerMetricAlertListener();

        $systemMetric = ServerMetric::factory()->create();
        $event = new ServerMetricAlertEvent($systemMetric->site, 'resource', 'usage', true);

        $instance->handle($event);

        Notification::assertSentTo($this->users, ServerMetricNotification::class);
    }
}
