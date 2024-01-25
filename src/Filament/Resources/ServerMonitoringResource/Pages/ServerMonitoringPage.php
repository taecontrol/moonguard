<?php

namespace Taecontrol\MoonGuard\Filament\Resources\ServerMonitoringResource\Pages;

use Filament\Resources\Pages\Page;
use Taecontrol\MoonGuard\Models\Site;
use Illuminate\Database\Eloquent\Collection;
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

    public bool $metricsAvailable = false;

    public bool $sitesAvailable = false;

    public bool $needsToSelect = false;

    public $siteId = null;

    protected $queryString = ['siteId'];

    public function mount(): void
    {
        $sites = Site::all();

        if (! $sites->isEmpty()) {
            $this->sitesAvailable = true;
        }
    }

    public function siteChanged(): void
    {
        if ($this->siteId !== '') {
            $this->dispatch('selected-site-changed', siteId: $this->siteId);
            $this->needsToSelect = false;
        }
    }

    protected function getViewData(): array
    {
        /** @var Collection */
        $sites = Site::all();

        return [
            'sites' => $sites,
        ];
    }

    protected function getFooterWidgets(): array
    {
        if (! $this->sitesAvailable || $this->needsToSelect) {
            return [];
        }

        return [
            CpuLoadChart::make(['siteId' => $this->siteId]),
            MemoryLoadChart::make(['siteId' => $this->siteId]),
            DiskSpaceChart::make(['siteId' => $this->siteId]),
        ];
    }
}
