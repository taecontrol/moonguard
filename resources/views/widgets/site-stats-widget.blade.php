<x-filament-widgets::widget>
    @if($sites->count() <= 0)
        <div class="flex items-center justify-center w-full py-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="flex flex-col items-center">
                <p class="text-xl text-center text-gray-500">
                    There are no sites at the moment
                </p>
                <a href="{{route('filament.moonguard.resources.sites.create')}}" class="mt-4">
                    <x-filament::button>
                        Create a new one
                    </x-filament::button>
                </a>
            </div>
        </div>
    @endif
    <div
        class="grid grid-cols-1 gap-4 lg:grid-cols-2 xl:grid-cols-3"{!! ($pollingInterval = $this->getPollingInterval()) ? "wire:poll.{$pollingInterval}" : '' !!} >
        @foreach($sites as $site)
            <x-filament::card>
                <div class="divide-y divide-gray-200">
                    <a class="pb-2" href="{{ route('filament.moonguard.resources.sites.edit', ['record' => $site->id]) }}">
                        <h3 class="text-xl font-bold">{{ $site->name }}</h3>
                        <span class="text-sm text-gray-400">{{$site->url}}</span>
                    </a>

                    <div class="pt-2 space-y-2">
                        <x-moonguard::site-stats-widget.uptime-list-item  :site="$site"/>
                        <x-moonguard::site-stats-widget.performace-list-item :site="$site" />
                        <x-moonguard::site-stats-widget.certificate-list-item :site="$site" />
                        <x-moonguard::site-stats-widget.exceptions-list-item :site="$site" />
                    </div>
                </div>
            </x-filament::card>
        @endforeach
    </div>
</x-filament-widgets::widget>
