<?php

namespace Taecontrol\Larastats\Filament\Resources\ExceptionLogResource\Pages;

use Illuminate\Support\Str;
use Livewire\WithPagination;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Taecontrol\Larastats\Contracts\LarastatsSite;
use Taecontrol\Larastats\Enums\ExceptionLogStatus;
use Taecontrol\Larastats\Filament\Resources\SiteResource;
use Taecontrol\Larastats\Contracts\LarastatsExceptionLogGroup;
use Taecontrol\Larastats\Repositories\ExceptionLogGroupRepository;

class SiteExceptionLogs extends Page
{
    use WithPagination;

    public LarastatsSite $site;

    public LarastatsExceptionLogGroup $exceptionLogGroup;

    public string $exceptionLogStatusFilter = '';

    protected static string $view = 'larastats::resources.exception-log-resource.pages.site-exception-logs';

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
        return 'larastats::partials.pagination';
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
        return view('larastats::resources.exception-log-resource.partials.site-exception-logs-header')
            ->with([
                'site' => $this->site,
            ]);
    }
}
