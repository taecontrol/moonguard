<?php

namespace Taecontrol\MoonGuard\Tests\Feature\Livewire;

use Taecontrol\MoonGuard\Tests\TestCase;
use Taecontrol\MoonGuard\Models\ExceptionLog;
use Taecontrol\MoonGuard\Enums\ExceptionLogStatus;
use Taecontrol\MoonGuard\Models\ExceptionLogGroup;
use Taecontrol\MoonGuard\Contracts\MoonGuardExceptionLogGroup;
use Taecontrol\MoonGuard\Filament\Resources\ExceptionLogResource\Pages\SiteExceptionLogs;

class SiteExceptionLogsTest extends TestCase
{
    /** @var MoonGuardExceptionLogGroup<ExceptionLogGroup> */
    protected MoonGuardExceptionLogGroup $ExceptionLogGroup;

    protected SiteExceptionLogs $siteExceptionLogs;

    public function setUp(): void
    {
        parent::setUp();

        $this->ExceptionLogGroup = ExceptionLogGroup::factory()
            ->has(
                ExceptionLog::factory()
                    ->state([
                        'status' => ExceptionLogStatus::UNRESOLVED,
                    ])
                    ->count(10)
            )
            ->create(['id' => 1]);

        $this->siteExceptionLogs = new SiteExceptionLogs();
        $this->siteExceptionLogs->exceptionLogGroup = $this->ExceptionLogGroup;
    }

    /** @test */
    public function it_updates_all_exceptionsLogs_status_from_current_page()
    {
        $allExceptionStatusAs = ExceptionLogStatus::RESOLVED->value;
        $exceptionLogStatusFilter = ExceptionLogStatus::UNRESOLVED->value;

        $this->siteExceptionLogs->allExceptionStatusAs = $allExceptionStatusAs;
        $this->siteExceptionLogs->exceptionLogStatusFilter = $exceptionLogStatusFilter;

        $exceptionLogs = $this->ExceptionLogGroup
            ->exceptionLogs()
            ->where('status', ExceptionLogStatus::UNRESOLVED)
            ->count();

        $this->siteExceptionLogs->updateAllExceptionLogStatus();

        $updatedExceptionLogs = $this->ExceptionLogGroup
            ->exceptionLogs()
            ->where('status', ExceptionLogStatus::RESOLVED)
            ->count();

        $this->assertEquals($exceptionLogs, $updatedExceptionLogs);
    }
}
