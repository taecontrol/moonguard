<?php

namespace Taecontrol\MoonGuard\Filament\Resources\MonitoringResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Taecontrol\MoonGuard\Filament\Resources\MonitoringResource;
use Taecontrol\MoonGuard\Filament\Resources\MonitoringResource\Widgets\MonitoringOverview;

class ListMonitoring extends ListRecords
{
    protected static string $resource = MonitoringResource::class;

    protected static ?string $title = 'System Metrics List';

    protected function getHeaderWidgets(): array
    {
        return [
            MonitoringOverview::class,
        ];
    }
}
