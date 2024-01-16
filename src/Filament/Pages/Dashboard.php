<?php

namespace Taecontrol\MoonGuard\Filament\Pages;

use Filament\Panel;
use Filament\Pages\Page;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Contracts\Support\Htmlable;
use Taecontrol\MoonGuard\Filament\Resources\SystemMonitoringResource\Widgets\CpuLoadChart;
use Taecontrol\MoonGuard\Filament\Resources\SystemMonitoringResource\Widgets\DiskSpaceChart;
use Taecontrol\MoonGuard\Filament\Resources\SystemMonitoringResource\Widgets\MemoryLoadChart;

class Dashboard extends Page
{
    protected static ?int $navigationSort = -2;

    /**
     * @var view-string
     */
    protected static string $view = 'filament-panels::pages.dashboard';

    public static function getNavigationLabel(): string
    {
        return static::$navigationLabel ??
            static::$title ??
            __('filament-panels::pages/dashboard.title');
    }

    public static function getNavigationIcon(): ?string
    {
        return static::$navigationIcon
            ?? FilamentIcon::resolve('panels::pages.dashboard.navigation-item')
            ?? (Filament::hasTopNavigation() ? 'heroicon-m-home' : 'heroicon-o-home');
    }

    public static function routes(Panel $panel): void
    {
        Route::get('/', static::class)
            ->middleware(static::getRouteMiddleware($panel))
            ->name(static::getSlug());
    }

    /**
     * @return array<class-string<Widget> | WidgetConfiguration>
     */
    public function getWidgets(): array
    {
        return Filament::getWidgets();
    }

    /**
     * @return array<class-string<Widget> | WidgetConfiguration>
     */
    public function getVisibleWidgets(): array
    {
        $widgets = $this->getWidgets();

        return array_filter($widgets, function ($widget) {
            $hiddenWidgets = [
                CpuLoadChart::class,
                DiskSpaceChart::class,
                MemoryLoadChart::class,
            ];

            return ! in_array($widget, $hiddenWidgets);
        });
    }

    /**
     * @return int | string | array<string, int | string | null>
     */
    public function getColumns(): int | string | array
    {
        return 2;
    }

    public function getTitle(): string | Htmlable
    {
        return static::$title ?? __('filament-panels::pages/dashboard.title');
    }
}
