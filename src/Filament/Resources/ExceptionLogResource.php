<?php

namespace Taecontrol\MoonGuard\Filament\Resources;

use Exception;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Taecontrol\MoonGuard\Filament\Tables\Columns\ExceptionColumn;
use Taecontrol\MoonGuard\Repositories\ExceptionLogGroupRepository;
use Taecontrol\MoonGuard\Filament\Resources\ExceptionLogResource\Pages\SiteExceptionLogs;
use Taecontrol\MoonGuard\Filament\Resources\ExceptionLogResource\Pages\ListExceptionLogGroups;

class ExceptionLogResource extends Resource
{
    protected static ?string $slug = 'exceptions';

    protected static ?string $modelLabel = 'Recent Exceptions';

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
                TextColumn::make('unresolved')->getStateUsing(function (Model $record) {
                    return $record->exceptionLogs()
                        ->where('status', 'unresolved')
                        ->count();
                }),
                TextColumn::make('first_seen')->dateTime()->sortable(),
                TextColumn::make('last_seen')->dateTime()->sortable(),
            ])
            ->defaultSort('last_seen', 'desc')
            ->filters([
                SelectFilter::make('sites')
                    ->relationship('site', 'name'),
                    SelectFilter::make('status')
                    ->options([
                        'unresolved' => 'Unresolved',
                        'reviewed' => 'Reviewed',
                        'ignored' => 'Ignored',
                        'resolved' => 'Resolved',
                    ])
                        ->query(function (Builder $query, array $data): Builder {
                            return $query
                                ->when(
                                    $data['value'] ?? null,
                                    fn (Builder $query, $value): Builder => $query->whereRelation('exceptionLogs', 'status', $value)
                                );
                        }),
      
            ], layout: FiltersLayout::AboveContent);
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

    public static function shouldRegisterNavigation(): bool
    {
        return ExceptionLogGroupRepository::isEnabled();
    }
}
