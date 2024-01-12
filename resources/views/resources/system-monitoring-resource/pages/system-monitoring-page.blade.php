@php
    $sitesWithMetrics = Taecontrol\MoonGuard\Models\SystemMetric::has('site')
        ->get()
        ->unique('site_id');
    $options = [];
    foreach ($sitesWithMetrics as $metric) {
        $options[$metric->site->id] = $metric->site->name;
    }
@endphp

@php
   $sitesWithMetrics = Taecontrol\MoonGuard\Models\SystemMetric::has('site')
       ->get()
       ->unique('site_id');
   $options = [];
   foreach ($sitesWithMetrics as $metric) {
       $options[$metric->site->id] = $metric->site->name;
   }
@endphp

@if(count($options) > 0)
   <x-filament-panels::page>
       <x-filament::section class="flex-wrap">
           <x-slot name="heading">
               Select Site
           </x-slot>
           <div class="flex gap-4">
               <x-filament::input.wrapper>
                  <x-filament::input.select wire:model="selectedSiteId"
                      x-on:change="$wire.siteChanged($event.target.value)">
                      @foreach ($options as $id => $name)
                          <option value="{{ $id }}">{{ $name }}</option>
                      @endforeach
                  </x-filament::input.select>
               </x-filament::input.wrapper>
           </div>
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
