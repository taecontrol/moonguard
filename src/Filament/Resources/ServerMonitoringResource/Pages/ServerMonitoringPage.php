<?php

namespace Taecontrol\MoonGuard\Filament\Resources\ServerMonitoringResource\Pages;

use Filament\Resources\Pages\Page;
use Taecontrol\MoonGuard\Models\Site;
use Filament\Forms\Concerns\InteractsWithForms;
use Taecontrol\MoonGuard\Filament\Resources\ServerMonitoringResource;
use Taecontrol\MoonGuard\Filament\Resources\ServerMonitoringResource\Widgets\CpuLoadChart;
use Taecontrol\MoonGuard\Filament\Resources\ServerMonitoringResource\Widgets\DiskSpaceChart;
use Taecontrol\MoonGuard\Filament\Resources\ServerMonitoringResource\Widgets\MemoryLoadChart;

class ServerMonitoringPage extends Page
{
    use InteractsWithForms;

    protected static string $resource = ServerMonitoringResource::class;

    protected static ?string $breadcrumb = '';

    protected static ?string $title = 'Server Monitoring';

    protected static string $view = 'moonguard::resources.server-monitoring-resource.pages.server-monitoring-page';

    protected $columnSpan = 'full';

    protected static ?int $sort = 1;

    public bool $noMetricsAvailable = false;

    public ?array $data = [];

    public $selectedSiteId;

    public function mount(): void
    {
        $siteWithMetrics = Site::whereHas('systemMetrics')->first();

        if ($siteWithMetrics !== null) {
            $this->selectedSiteId = $siteWithMetrics->id;
        } else {
            $this->noMetricsAvailable = true;
        }
    }

    public function siteChanged(): void
    {
        $this->dispatch('selected-site-changed', siteId: $this->selectedSiteId);
    }

    protected function getFooterWidgets(): array
    {
        if (! $this->noMetricsAvailable) {
            return [
                CpuLoadChart::make(['selectedSiteId' => $this->selectedSiteId]),
                MemoryLoadChart::make(['selectedSiteId' => $this->selectedSiteId]),
                DiskSpaceChart::make(['selectedSiteId' => $this->selectedSiteId]),
            ];
        }

        return [];
    }
}
