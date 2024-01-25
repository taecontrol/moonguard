<div>
    @if ($sites->isEmpty())
        <x-filament-panels::page>
            <x-filament::section>
                <x-slot name="heading">
                    There are no sites at the moment.
                </x-slot>
                <p>There are currently no sites with metrics available.</p>
            </x-filament::section>
        </x-filament-panels::page>
    @else
        <x-filament-panels::page>
            <x-filament::section>
                <x-slot name="heading">
                    Site
                </x-slot>
                <x-slot name="description">
                    Select a site to load it's monitoring data.
                </x-slot>
                <x-filament::input.wrapper class="w-full">
                    <x-filament::input.select wire:model="siteId" x-on:change="$wire.siteChanged($event.target.value)">
                        @if (!$siteId)
                            <option value="">Select a site</option>
                        @endif
                        @foreach ($sites as $site)
                            <option class="py-2" value="{{ $site->id }}">{{ $site->name }}</option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </x-filament::section>
        </x-filament-panels::page>
    @endif
</div>
