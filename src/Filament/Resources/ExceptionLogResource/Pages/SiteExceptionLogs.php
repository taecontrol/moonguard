<?php

namespace Taecontrol\MoonGuard\Filament\Resources\ExceptionLogResource\Pages;

use Illuminate\Support\Str;
use Livewire\WithPagination;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Taecontrol\MoonGuard\Contracts\MoonGuardSite;
use Taecontrol\MoonGuard\Enums\ExceptionLogStatus;
use Taecontrol\MoonGuard\Filament\Resources\SiteResource;
use Taecontrol\MoonGuard\Repositories\ExceptionLogRepository;
use Taecontrol\MoonGuard\Contracts\MoonGuardExceptionLogGroup;
use Taecontrol\MoonGuard\Repositories\ExceptionLogGroupRepository;

class SiteExceptionLogs extends Page
{
    use WithPagination;

    public MoonGuardSite $site;

    public MoonGuardExceptionLogGroup $exceptionLogGroup;

    public Collection $exceptionLogsCollection;

    public string $allExceptionStatusAs = '';

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

    public function updateExceptionLogStatus(int $exceptionId, string $status)
    {
        $status = ExceptionLogStatus::from($status)->value;
        ExceptionLogRepository::query()
            ->find($exceptionId)
            ->update(['status' => $status]);
    }

    public function updateAllExceptionLogStatus()
    {
        $status = ExceptionLogStatus::from($this->allExceptionStatusAs)->value;

        if ($this->allExceptionStatusAs !== '') {

            $this->exceptionLogGroup
                ->exceptionLogs()
                ->when(
                    fn () => Str::length($this->exceptionLogStatusFilter) > 0,
                    fn (Builder $query) => $query->where('status', $this->exceptionLogStatusFilter)
                )
                ->update(['status' => $status]);
        }
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

    public function getHeader(): ?View
    {
        return view('moonguard::resources.exception-log-resource.partials.site-exception-logs-header')
            ->with([
                'site' => $this->site,
            ]);
    }

    public function filterByStatus($status)
    {
        $this->exceptionLogStatusFilter = $status;
        $this->getViewData();
    }

    protected function getViewData(): array
    {
        /** @var LengthAwarePaginator $exceptions */
        $exceptions = $this
            ->exceptionLogGroup
            ->exceptionLogs()
            ->orderByDesc('thrown_at')
            ->when(
                fn () => Str::length($this->exceptionLogStatusFilter) > 0,
                fn (Builder $query) => $query->where('status', $this->exceptionLogStatusFilter)
            )
            ->paginate(5);

        $this->exceptionLogsCollection = $exceptions->getCollection();

        return [
            'exceptions' => $exceptions,
        ];
    }
}
