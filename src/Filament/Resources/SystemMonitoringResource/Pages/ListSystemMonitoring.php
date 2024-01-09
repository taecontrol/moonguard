<?php

namespace Taecontrol\MoonGuard\Filament\Resources\SystemMonitoringResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Taecontrol\MoonGuard\Filament\Resources\SystemMonitoringResource;
use Taecontrol\MoonGuard\Filament\Resources\SystemMonitoringResource\Widgets\SystemMonitoringOverview;

class ListSystemMonitoring extends ListRecords
{
    protected static string $resource = SystemMonitoringResource::class;

    protected static ?string $title = 'System Monitoring List';

    public function getRecordPageRoute($record): string
    {
        return route('filament.moonguard.resources.system-monitoring.index');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            SystemMonitoringOverview::class,
        ];
    }
}
