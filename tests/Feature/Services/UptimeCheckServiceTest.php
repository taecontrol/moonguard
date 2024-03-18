<?php

namespace Taecontrol\MoonGuard\Tests\Feature\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Taecontrol\MoonGuard\Models\Site;
use Taecontrol\MoonGuard\Models\User;
use Taecontrol\MoonGuard\Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use Taecontrol\MoonGuard\Enums\UptimeStatus;
use Taecontrol\MoonGuard\Models\UptimeCheck;
use Taecontrol\MoonGuard\Services\UptimeCheckService;
use Taecontrol\MoonGuard\Notifications\UptimeCheckFailedNotification;

class UptimeCheckServiceTest extends TestCase
{
    /** @var Collection<User> */
    protected Collection $users;

    protected UptimeCheckService $uptimeCheckService;

    public function setUp(): void
    {
        parent::setUp();

        $this->users = User::factory()->count(2)->create();

        $this->uptimeCheckService = app(UptimeCheckService::class);
    }

    /** @test */
    public function it_checks_uptime()
    {
        Http::fake();
        Notification::fake();

        $this->freezeTime();

        $site = Site::factory()->create();

        UptimeCheck::factory()->for($site)->create();

        $this->uptimeCheckService->check($site, Http::get($site->url));

        $uptime = $site->uptimeCheck()->first();

        $this->assertSame(UptimeStatus::UP, $uptime->status);
        $this->assertSame('', $uptime->check_failure_reason);
        $this->assertSame(0, $uptime->check_times_failed_in_a_row);
        $this->assertEquals(now()->timestamp, $uptime->last_check_date->timestamp);
        $this->assertNull($uptime->check_failed_event_fired_on_date);

        Notification::assertNothingSent();
    }

    /** @test */
    public function it_creates_a_new_uptime_if_it_doesnt_exist_while_checking_uptime()
    {
        Http::fake();
        Notification::fake();

        $site = Site::factory()->create();

        $this->uptimeCheckService->check($site, Http::get($site->url));

        $uptime = $site->first()->uptimeCheck()->first();

        $this->assertSame(UptimeStatus::UP, $uptime->status);

        Notification::assertNothingSent();
    }

    /** @test */
    public function it_checks_uptime_for_failing_sites()
    {
        Notification::fake();
        Http::fake([
            '*' => Http::response([], 404),
        ]);

        $site = Site::factory()->create();

        UptimeCheck::factory()->for($site)->create([
            'status_last_change_date' => now(),
            'last_check_date' => now(), ]);

        $this->uptimeCheckService->check($site, Http::get($site->url));

        $uptime = $site->first()->uptimeCheck()->first();

        $this->assertSame(UptimeStatus::DOWN, $uptime->status);
        $this->assertSame('Not Found', $uptime->check_failure_reason);
        $this->assertSame(1, $uptime->check_times_failed_in_a_row);
        $this->assertEquals(now()->timestamp, $uptime->last_check_date->timestamp);

        Notification::assertSentTo($this->users, UptimeCheckFailedNotification::class);
    }
}
