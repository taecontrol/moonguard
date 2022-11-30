<?php

namespace Taecontrol\Larastats\Filament\Resources\ExceptionLogGroupResource\Pages;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\ListRecords;
use Taecontrol\Larastats\Filament\Resources\ExceptionLogGroupResource;

class ListExceptionLogGroups extends ListRecords
{
    protected static string $resource = ExceptionLogGroupResource::class;

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
            'filament.resources.larastats/exceptions.show',
            ['record' => $record]
        );
    }
}
