<?php

namespace Taecontrol\MoonGuard\Filament\Resources\SystemMonitoringResource\Pages;

use Filament\Resources\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Taecontrol\MoonGuard\Filament\Resources\SystemMonitoringResource;

class SystemMonitoringPage extends Page
{
    use InteractsWithForms;

    protected static string $resource = SystemMonitoringResource::class;

    protected static string $view = 'moonguard::resources.system-monitoring-resource.pages.system-monitoring-page';

    protected $columnSpan = 'full';

    protected static ?int $sort = 1;

    public ?array $data = [];

    public $selectedSiteId;

}
