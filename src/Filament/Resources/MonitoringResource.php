<?php

namespace Taecontrol\MoonGuard\Filament\Resources;

use Filament\Tables\Table;
use Filament\Resources\Resource;
use Taecontrol\MoonGuard\Models\SystemMetric;
use Taecontrol\MoonGuard\Filament\Resources\MonitoringResource\Pages\ListMonitoring;

class MonitoringResource extends Resource
{
    protected static ?string $model = SystemMetric::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function table(Table $table): Table
    {
        return $table
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMonitoring::route('/'),
        ];
    }
}
