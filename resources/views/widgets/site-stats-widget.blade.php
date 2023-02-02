<x-filament::widget>
    @if($sites->count() <= 0)
        <div class="flex justify-center items-center bg-white w-full h-[200px] rounded-lg shadow-md">
            <div class="flex flex-col items-center">
                <p class="text-xl text-gray-500 text-center">
                    There are no sites at the moment
                </p>
                <a href="{{route('filament.resources.moonguard/sites.create')}}" class="mt-4">
                    <x-filament::button>
                        Create a new one
                    </x-filament::button>
                </a>
            </div>
        </div>
    @endif
    <div
        class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4"{!! ($pollingInterval = $this->getPollingInterval()) ? "wire:poll.{$pollingInterval}" : '' !!} >
        @foreach($sites as $site)
            <x-filament::card>
                <div class="divide-y divide-gray-200">
                    <a class="pb-2" href="{{ route('filament.resources.moonguard/sites.edit', ['record' => $site->id]) }}">
                        <h3 class="font-bold text-xl">{{ $site->name }}</h3>
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
</x-filament::widget>
