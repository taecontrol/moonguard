<?php

namespace Taecontrol\Larastats\Filament\Resources;

use Exception;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Taecontrol\Larastats\Filament\Resources\ExceptionLogGroupResource\Pages\ListExceptionLogGroups;
use Taecontrol\Larastats\Filament\Resources\ExceptionLogGroupResource\Pages\SiteExceptions;
use Taecontrol\Larastats\Filament\Tables\Columns\ExceptionLogGroupColumn;
use Taecontrol\Larastats\Repositories\ExceptionLogGroupRepository;

class ExceptionLogGroupResource extends Resource
{
    protected static ?string $slug = 'larastats/exceptions';

    protected static ?string $modelLabel = 'All Exceptions';

    protected static ?string $navigationLabel = 'Exceptions';

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-circle';

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ExceptionLogGroupColumn::make('exceptions'),
                TextColumn::make('exception_logs_count')->counts('exceptionLogs')->label('Events'),
                TextColumn::make('first_seen')->dateTime()->sortable(),
                TextColumn::make('last_seen')->dateTime()->sortable(),
            ])
            ->defaultSort('last_seen', 'desc')
            ->filters([
                SelectFilter::make('sites')
                    ->relationship('site', 'name'),
            ], layout: Layout::AboveContent);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getModel(): string
    {
        return ExceptionLogGroupRepository::resolveModelClass();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListExceptionLogGroups::route('/'),
            'show' => SiteExceptions::route('/show/{record}'),
        ];
    }
}
