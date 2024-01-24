@php
    $sitesWithMetrics = Taecontrol\MoonGuard\Models\ServerMetric::has('site')
        ->get()
        ->unique('site_id');
    $options = [];
    foreach ($sitesWithMetrics as $metric) {
        $options[$metric->site->id] = $metric->site->name;
    }
@endphp

@if (count($options) > 0)
    <x-filament-panels::page>
        <x-filament::section>
            <x-slot name="heading">
                Site
            </x-slot>
            <x-slot name="description">
                Select a site to load it's monitoring data.
            </x-slot>
            <x-filament::input.wrapper class="w-full">
                <x-filament::input.select wire:model="selectedSiteId"
                    x-on:change="$wire.siteChanged($event.target.value)">
                    @foreach ($options as $id => $name)
                        <option class="py-2" value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </x-filament::input.select>
            </x-filament::input.wrapper>
        </x-filament::section>
    </x-filament-panels::page>
@else
    <x-filament-panels::page>
        <x-filament::section>
            <x-slot name="heading">
                No sites with metrics
            </x-slot>
            <p>There are currently no sites with metrics available.</p>
        </x-filament::section>
    </x-filament-panels::page>
@endif
