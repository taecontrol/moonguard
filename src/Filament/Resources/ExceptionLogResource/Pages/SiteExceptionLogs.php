<?php

namespace Taecontrol\Moonguard\Filament\Resources\ExceptionLogResource\Pages;

use Illuminate\Support\Str;
use Livewire\WithPagination;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Taecontrol\Moonguard\Contracts\MoonguardSite;
use Taecontrol\Moonguard\Enums\ExceptionLogStatus;
use Taecontrol\Moonguard\Filament\Resources\SiteResource;
use Taecontrol\Moonguard\Contracts\MoonguardExceptionLogGroup;
use Taecontrol\Moonguard\Repositories\ExceptionLogGroupRepository;

class SiteExceptionLogs extends Page
{
    use WithPagination;

    public MoonguardSite $site;

    public MoonguardExceptionLogGroup $exceptionLogGroup;

    public string $exceptionLogStatusFilter = '';

    protected static string $view = 'moonguard::resources.exception-log-resource.pages.site-exception-logs';

    protected static string $resource = SiteResource::class;

    protected $queryString = [
        'exceptionLogStatusFilter' => ['as' => 'status', 'except' => ''],
    ];

    public function mount(int $record)
    {
        $this->exceptionLogStatusFilter = ExceptionLogStatus::UNRESOLVED->value;
        $this->exceptionLogGroup = ExceptionLogGroupRepository::findOrFail($record);
        $this->site = $this->exceptionLogGroup->site;
    }

    public function paginationView(): string
    {
        return 'moonguard::partials.pagination';
    }

    public function getExceptionLogStatusFilterOptionsProperty(): array
    {
        return [
            ExceptionLogStatus::UNRESOLVED->value => 'Unresolved',
            ExceptionLogStatus::RESOLVED->value => 'Resolved',
            ExceptionLogStatus::IGNORED->value => 'Ignored',
            ExceptionLogStatus::REVIEWED->value => 'Reviewed',
        ];
    }

    protected function getViewData(): array
    {
        $exceptions = $this
            ->exceptionLogGroup
            ->exceptionLogs()
            ->orderByDesc('thrown_at')
            ->when(
                fn () => Str::length($this->exceptionLogStatusFilter) > 0,
                fn (Builder $query) => $query->where('status', $this->exceptionLogStatusFilter)
            )
            ->paginate(5);

        return [
            'exceptions' => $exceptions,
        ];
    }

    protected function getHeader(): ?View
    {
        return view('moonguard::resources.exception-log-resource.partials.site-exception-logs-header')
            ->with([
                'site' => $this->site,
            ]);
    }
}
