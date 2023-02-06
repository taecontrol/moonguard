<x-filament::page>
    <div class="grid xl:grid-cols-3 grid-cols-1 gap-4">
        <div>
            <label class="text-gray-600 text-sm">Status</label>
            <x-moonguard::dropdown placeholder="Status filter" :options="$this->exceptionLogStatusFilterOptions" wire:model="exceptionLogStatusFilter" />
        </div>
        <div></div>
        <div>
            @if ($exceptions->count() > 0)
                <label class="text-gray-600 text-sm">Update exceptions status as</label>
                <div class="w-full flex justify-between">
                    <div class="w-full">
                        <x-moonguard::dropdown placeholder="Status" :options="$this->exceptionLogStatusFilterOptions" wire:model="allExceptionStatusAs" />
                    </div>
                    <div class="ml-2" wire:click="updateAllExceptionLogStatus">
                        <x-filament::button class="w-full">
                            Update
                        </x-filament::button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div x-data="{selected: null}">
        @if ($exceptions->count() <= 0)
            <div class="flex justify-center items-center h-[300px] bg-white rounded-md">
                <p class="text-2xl italic text-gray-500">There are no Exceptions at the time!</p>
            </div>
        @endif

        <ul class="overflow-hidden bg-white shadow sm:rounded-md divide-y divide-gray-200">
            @foreach($exceptions as $exception)
                <li class="relative">
                    <button type="button" class="w-full p-6 text-left" :class="selected === {{$loop->index}} ? '!bg-primary-900 !hover:bg-primary-800' : 'bg-white hover:bg-primary-50'" @click="selected !== {{ $loop->index }} ? selected = {{ $loop->index }} : selected = null">
                        <div class="truncate">
                            <div class="flex justify-between text-sm" :class="selected === {{$loop->index}} ? 'text-gray-400' : 'text-gray-500'">
                                <p class="truncate font-medium">{{$exception->type}}</p>
                                <p>{{ $exception->thrown_at->toCookieString() }}</p>
                            </div>
                            <div class="mt-2 flex">
                                <p class="text-xl font-bold" :class="selected === {{$loop->index}} ? 'text-white' : 'text-gray-900'">
                                    {{$exception->message}}
                                </p>
                            </div>
                            <p class="mt-2 truncate font-medium text-sm" :class="selected === {{$loop->index}} ? 'text-gray-400' : 'text-gray-500'">{{$exception->file}}</p>
                        </div>
                    </button>


                    <div class="relative overflow-hidden max-h-0 transition-all !duration-700" style="" x-ref="container{{ $loop->index }}" x-bind:style="selected == {{ $loop->index }} ? 'max-height: ' + $refs.container{{ $loop->index }}.scrollHeight + 'px' : ''">
                        <div class="mt-10 px-4 py-5 sm:px-6">

                            <div class="mb-6 w-full" x-data="{ selection: '{{ $exception->status->value }}' }">
                                <h3 class="text-lg font-bold leading-6 text-gray-900">Status</h3>
                                <div class="flex">
                                    <div>
                                        <x-moonguard::select 
                                            model="selection"
                                            :options="$this->exceptionLogStatusFilterOptions" 
                                            :default="$exception->status->value" 
                                        />
                                    </div>
                                    <div class="ml-2">
                                        <x-filament::button class="w-full" x-on:click="$wire.updateExceptionLogStatus( {{ $exception->id }}, selection )">
                                            Update
                                        </x-filament::button>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-bold leading-6 text-gray-900">Message</h3>
                                <p class="mt-1 text-sm text-gray-900">{{ $exception->message }}</p>
                            </div>
                            
                            <br />

                            <h3 class="text-lg font-bold leading-6 text-gray-900">Request</h3>

                            <dl class="mt-4 grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">

                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">URL</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $exception->request['url'] }}</dd>
                                </div>

                                @if(isset($exception->request['params']) && count($exception->request['params']) > 0)
                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">Parameters</dt>
                                        <div class="mt-2">
                                            @foreach($exception->request['params'] as $key => $value)
                                                <div class="{{ $loop->even  ? 'bg-gray-100' : 'bg-white' }} px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4">
                                                    <dt class="text-sm font-medium text-gray-500">{{ $key }}</dt>
                                                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ is_array($value) ? Str::replace(',', ', ', $value[0]) : $value }}</dd>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if(isset($exception->request['headers']) && count($exception->request['headers']) > 0)
                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">Headers</dt>
                                        <div class="mt-2">
                                            @foreach($exception->request['headers'] as $key => $value)
                                                <div class="{{ $loop->even  ? 'bg-gray-100' : 'bg-white' }} px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4">
                                                    <dt class="text-sm font-medium text-gray-500">{{ $key }}</dt>
                                                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ is_array($value) ? Str::replace(',', ', ', $value[0]) : $value }}</dd>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        @if(isset($exception->trace) && count($exception->trace) > 0)
                            <div class="mt-2 px-4 sm:px-6">
                                <h3 class="text-lg font-bold leading-6 text-gray-900">Trace</h3>
                            </div>

                            <div class="px-6 py-2 divide-y divide-gray-200">
                                @foreach($exception->trace as $traceItem)
                                    <div class="py-4 text-sm">
                                        <p class="text-gray-500">{{array_key_exists('class', $traceItem) ? $traceItem['class'] : $traceItem['file']}}:<code>{{$traceItem['line']}}</code></p>
                                        <p class="font-medium">{{$traceItem['function']}}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>

        <div class="mt-4">
            {{ $exceptions->links() }}
        </div>
    </div>
</x-filament::page>
