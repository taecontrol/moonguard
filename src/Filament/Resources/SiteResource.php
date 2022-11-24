<?php

namespace Taecontrol\Larastats\Filament\Resources;

use Exception;
use Str;
use Closure;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Actions\Action;
use Taecontrol\Larastats\Contracts\LarastatsSite;
use Taecontrol\Larastats\Filament\Resources\SiteResource\Pages\CreateSite;
use Taecontrol\Larastats\Filament\Resources\SiteResource\Pages\EditSite;
use Taecontrol\Larastats\Filament\Resources\SiteResource\Pages\ListSites;
use Taecontrol\Larastats\Repositories\SiteRepository;

class SiteResource extends Resource
{
    protected static ?string $slug = 'larastats/sites';

    protected static ?string $modelLabel = 'Site';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * @throws Exception
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('url')
                    ->unique(ignorable: fn (?LarastatsSite $record): ?LarastatsSite => $record)
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('max_request_duration_ms')
                    ->label('Max. request duration')
                    ->default(1000)
                    ->numeric()
                    ->minValue(0)
                    ->suffix('ms')
                    ->required(),
                Fieldset::make('Enabled checks')
                    ->schema([
                        Checkbox::make('uptime_check_enabled')
                            ->label('Uptime check'),
                        Checkbox::make('ssl_certificate_check_enabled')
                            ->label('SSL certificate check'),
                    ]),
                Fieldset::make('API Token')
                    ->schema([
                        Toggle::make('api_token_enabled')
                            ->reactive()
                            ->columnSpan('full')
                            ->label('Enabled')
                            ->afterStateUpdated(function (Closure $set, $state) {
                                if ($state) {
                                    $set('api_token', Str::random(60));
                                } else {
                                    $set('api_token', null);
                                }
                            }),
                        TextInput::make('api_token')
                            ->reactive()
                            ->columnSpan('full')
                            ->disableLabel()
                            ->disabled()
                            ->suffixAction(
                                Action::make('regenerate')
                                    ->disabled(function (CreateSite|EditSite $livewire) {
                                        return ! $livewire->data['api_token_enabled'];
                                    })
                                    ->icon('heroicon-s-refresh')
                                    ->action(
                                        function (CreateSite|EditSite $livewire) {
                                            if ($livewire->data['api_token_enabled']) {
                                                $livewire->data['api_token'] = Str::random(60);
                                            }
                                        }
                                    )
                                    ->requiresConfirmation()
                            ),
                    ]),

                Toggle::make('down_for_maintenance')
                    ->columnSpan('full')
                    ->label('Down for maintenance'),
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('url')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getModel(): string
    {
        return SiteRepository::resolveModelClass();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSites::route('/'),
            'create' => CreateSite::route('/create'),
            'edit' => EditSite::route('/{record}/edit'),
        ];
    }
}
