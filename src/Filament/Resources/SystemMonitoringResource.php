<?php

namespace Taecontrol\MoonGuard\Filament\Resources;

use Filament\Resources\Resource;
use Taecontrol\MoonGuard\Filament\Resources\SystemMonitoringResource\Widgets\DiskSpaceChart;
use Taecontrol\MoonGuard\Filament\Resources\SystemMonitoringResource\Widgets\MemoryLoadChart;
use Taecontrol\MoonGuard\Models\SystemMetric;
use Taecontrol\MoonGuard\Filament\Resources\SystemMonitoringResource\Widgets\CpuLoadChart;
use Taecontrol\MoonGuard\Filament\Resources\SystemMonitoringResource\Pages\SystemMonitoringPage;

class SystemMonitoringResource extends Resource
{
    //protected static ?string $model = SystemMetric::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getPages(): array
    {
        return [
            'index' => SystemMonitoringPage::route('/'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            CpuLoadChart::class,
            MemoryLoadChart::class,
            DiskSpaceChart::class,
        ];
    }
}
