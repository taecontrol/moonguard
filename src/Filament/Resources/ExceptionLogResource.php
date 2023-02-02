<?php

namespace Taecontrol\Moonguard\Filament\Resources;

use Exception;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Taecontrol\Moonguard\Filament\Tables\Columns\ExceptionColumn;
use Taecontrol\Moonguard\Repositories\ExceptionLogGroupRepository;
use Taecontrol\Moonguard\Filament\Resources\ExceptionLogResource\Pages\SiteExceptionLogs;
use Taecontrol\Moonguard\Filament\Resources\ExceptionLogResource\Pages\ListExceptionLogGroups;

class ExceptionLogResource extends Resource
{
    protected static ?string $slug = 'moonguard/exceptions';

    protected static ?string $modelLabel = 'Latest Exceptions';

    protected static ?string $navigationLabel = 'Exceptions';

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-circle';

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ExceptionColumn::make('exceptions'),
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
            'show' => SiteExceptionLogs::route('/show/{record}'),
        ];
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return ExceptionLogGroupRepository::isEnabled();
    }
}
