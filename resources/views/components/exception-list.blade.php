<div x-data="{ selected: null }">
    @if ($exceptions->count() <= 0)
        <div class="flex justify-center items-center h-[300px] bg-white rounded-md dark:bg-gray-900">
            <p class="text-2xl italic text-gray-500">There are no Exceptions at the time!</p>
        </div>
    @endif
                       
    <ul class="overflow-hidden bg-white divide-gray-200 dark:divide-gray-600 border dark:border-gray-600 shadow sm:rounded-md divide-y dark:bg-gray-900">
        @foreach ($exceptions as $exception)
            <li class="relative">
                <button type="button" class="w-full p-6 text-left focus:outline-none"
                    :class="selected === {{ $loop->index }} ? '!bg-primary-800 dark:bg-primary-100' : 
                        'bg-white hover:bg-primary-50 dark:bg-gray-900' "
                    @click="selected !== {{ $loop->index }} ? selected = {{ $loop->index }} : selected = null">
                    <div class="truncate">
                        <div class="flex justify-between text-sm"
                            :class="selected === {{ $loop->index }} ? 'text-gray-400 dark:text-gray-300' : 'text-gray-500 dark:text-gray-400'">
                            <p class="truncate font-medium">{{ $exception->type }}</p>
                            <p>{{ $exception->thrown_at->toCookieString() }}</p>
                        </div>
                        <div class="mt-2 flex">
                            <p class="text-xl font-bold"
                                :class="selected === {{ $loop->index }} ? 'text-white' : 'text-gray-900 dark:text-gray-100'">
                                {{ $exception->message }}
                            </p>
                        </div>
                        <p class="mt-2 truncate font-medium text-sm"
                            :class="selected === {{ $loop->index }} ? 'text-gray-400' : 'text-gray-500 dark:text-gray-400'">
                            {{ $exception->file }}</p>
                    </div>
                </button>


                <div class="relative overflow-hidden max-h-0 transition-all dark:bg-gray-900 !duration-700" style=""
                    x-ref="container{{ $loop->index }}"
                    x-bind:style="selected == {{ $loop->index }} ? 'max-height: ' + $refs.container{{ $loop->index }}
                        .scrollHeight + 'px' :
                        ''">
                    <div class="mt-10 px-4 py-5 sm:px-6">

                        <div class="mb-6 w-full" x-data="{ selection: '{{ $exception->status->value }}' }">
                            <h3 class="text-lg font-bold leading-6 text-gray-900 dark:text-gray-200">Status</h3>
                            <div class="flex">
                                <div>
                                    <x-moonguard::select model="selection" :options="$this->exceptionLogStatusFilterOptions" :default="$exception->status->value" />
                                </div>
                                <div class="ml-2">
                                    <x-filament::button class="w-full"
                                        x-on:click="$wire.updateExceptionLogStatus( {{ $exception->id }}, selection )">
                                        Update
                                    </x-filament::button>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold leading-6 text-gray-900 dark:text-gray-200">Message</h3>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-400">{{ $exception->message }}</p>
                        </div>

                        <br />

                        <h3 class="text-lg font-bold leading-6 text-gray-900 dark:text-gray-200">Request</h3>

                        <dl class="mt-4 grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">

                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">URL</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $exception->request['url'] }}</dd>
                            </div>

                            @if (isset($exception->request['params']) && count($exception->request['params']) > 0)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Parameters</dt>
                                    <div class="mt-2">
                                        @foreach ($exception->request['params'] as $key => $value)
                                            <div
                                                class="{{ $loop->even ? 'bg-gray-100 dark:bg-gray-900' : 'bg-white dark:bg-gray-800' }} px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4">
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $key }}</dt>
                                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:col-span-2 sm:mt-0 break-words">
                                                    {{ is_array($value) ? Str::replace(',', ', ', $value[0]) : $value }}
                                                </dd>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if (isset($exception->request['headers']) && count($exception->request['headers']) > 0)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Headers</dt>
                                    <div class="mt-2">
                                        @foreach ($exception->request['headers'] as $key => $value)
                                            <div
                                                class="{{ $loop->even ? 'bg-gray-100 dark:bg-gray-900' : 'bg-white dark:bg-gray-800' }} px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4">
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $key }}</dt>
                                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:col-span-2 sm:mt-0 break-words">
                                                    {{ is_array($value) ? Str::replace(',', ', ', $value[0]) : $value }}
                                                </dd>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </dl>
                    </div>

                    @if (isset($exception->trace) && count($exception->trace) > 0)
                        <div class="mt-2 px-4 sm:px-6">
                            <h3 class="text-lg font-bold leading-6 text-gray-900 dark:text-gray-200">Trace</h3>
                        </div>

                        <div class="px-6 py-2 divide-y divide-gray-200 dark:divide-gray-600">
                            @foreach ($exception->trace as $traceItem)
                                <div class="py-4 text-sm">
                                    <p class="text-gray-500 dark:text-gray-400">
                                        {{ array_key_exists('class', $traceItem) ? $traceItem['class'] : $traceItem['file'] }}:<code>{{ $traceItem['line'] }}</code>
                                    </p>
                                    <p class="font-medium">{{ $traceItem['function'] }}</p>
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
