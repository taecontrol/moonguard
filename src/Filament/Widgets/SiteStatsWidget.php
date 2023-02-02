<?php

namespace Taecontrol\Moonguard\Filament\Widgets;

use Taecontrol\Moonguard\Repositories\SiteRepository;

class SiteStatsWidget extends PollableWidget
{
    protected static ?string $pollingInterval = '10s';

    protected static string $view = 'moonguard::widgets.site-stats-widget';

    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'sites' => SiteRepository::query()
                ->with(['uptimeCheck', 'sslCertificateCheck'])
                ->withCount(['exceptionLogs'])
                ->get(),
        ];
    }
}
