<?php

namespace Taecontrol\Moonguard\Filament\Resources\ExceptionLogResource\Pages;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\ListRecords;
use Taecontrol\Moonguard\Filament\Resources\ExceptionLogResource;

class ListExceptionLogGroups extends ListRecords
{
    protected static string $resource = ExceptionLogResource::class;

    protected function getTableFiltersFormColumns(): int
    {
        return 1;
    }

    protected function getTableFiltersFormWidth(): string
    {
        return '7xl';
    }

    protected function getTableRecordUrlUsing(): Closure
    {
        return fn (Model $record): string => route(
            'filament.resources.moonguard/exceptions.show',
            ['record' => $record]
        );
    }
}
