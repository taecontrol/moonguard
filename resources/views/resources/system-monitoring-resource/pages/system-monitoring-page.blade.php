@php
    $sitesWithMetrics = Taecontrol\MoonGuard\Models\SystemMetric::has('site')
        ->get()
        ->unique('site_id');
    $options = [];
    foreach ($sitesWithMetrics as $metric) {
        $options[$metric->site->id] = $metric->site->name;
    }
@endphp

<x-filament-panels::page>
   <x-filament::section class="flex-wrap">
       <div class="flex gap-4">
           <x-filament::input.wrapper>
               <x-filament::input.select wire:model="selectedSiteId" x-on:change="$wire.siteChanged($event.target.value)">
                  @foreach ($options as $id => $name)
                      <option value="{{ $id }}">{{ $name }}</option>
                  @endforeach
               </x-filament::input.select>
           </x-filament::input.wrapper>
       </div>
   </x-filament::section>
   {{-- <div>
       @livewire(Taecontrol\MoonGuard\Filament\Resources\SystemMonitoringResource\Widgets\CpuLoadChart::class, ['siteId' => $selectedSiteId])
   </div> --}}
</x-filament-panels::page>