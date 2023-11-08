<?php

namespace Taecontrol\MoonGuard\Tests\Feature\Livewire;

use Taecontrol\MoonGuard\Filament\Resources\ExceptionLogResource\Pages\ListExceptionLogGroups;
use Taecontrol\MoonGuard\Models\ExceptionLog;
use Taecontrol\MoonGuard\Tests\TestCase;

class ListExceptionLogGroupsTest extends TestCase
{
    /** @test */
    public function it_checks_getTableRecordUrlUsingMethod_has_the_correct_url()
    {
        $listRecords = new ListExceptionLogGroups();
        $record = new ExceptionLog();

        $url = $listRecords->getTableRecordUrlUsing($record);

        $this->assertEquals(
            $url,
            route('filament.moonguard.resources.exceptions.show', ['record' => $record])
        );
    }
}
