<?php

namespace Taecontrol\MoonGuard\Tests\Feature\Livewire;

use Taecontrol\MoonGuard\Contracts\MoonGuardExceptionLogGroup;
use Taecontrol\MoonGuard\Enums\ExceptionLogStatus;
use Taecontrol\MoonGuard\Filament\Resources\ExceptionLogResource\Pages\SiteExceptionLogs;
use Taecontrol\MoonGuard\Models\ExceptionLog;
use Taecontrol\MoonGuard\Models\ExceptionLogGroup;
use Taecontrol\MoonGuard\Tests\TestCase;
//use Livewire\Livewire;

class SiteExceptionLogsTest extends TestCase
{
    /** @var MoonGuardExceptionLogGroup<ExceptionLogGroup> */
    protected MoonGuardExceptionLogGroup $ExceptionLogGroup;

    protected SiteExceptionLogs $siteExceptionLogs;

    public function setUp(): void
    {
        parent::setUp();

        $this->ExceptionLogGroup = ExceptionLogGroup::factory()
                                    ->has(ExceptionLog::factory()
                                        ->state([
                                            'status' => ExceptionLogStatus::UNRESOLVED,
                                        ])
                                        ->count(10)
                                    )
                                    ->create();

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

        //Livewire::test(SiteExceptionLogs::class)
            //->set('allExceptionStatusAs', $allExceptionStatusAs)
            //->set('exceptionLogStatusFilter', $exceptionLogStatusFilter)
            //->call('updateAllExceptionLogStatus');

        $updatedExceptionLogs = $this->ExceptionLogGroup
                                    ->exceptionLogs()
                                    ->where('status', ExceptionLogStatus::RESOLVED)
                                    ->count();

        $this->assertEquals($exceptionLogs, $updatedExceptionLogs);
    }
}
