@if(! \Taecontrol\MoonGuard\Repositories\ExceptionLogRepository::isEnabled())
    <div class="flex items-center justify-between text-gray-500">
        <span>Exceptions</span>
        <span class="text-gray-400">Disabled</span>
    </div>
@else
    <a class="flex items-center justify-between text-gray-500 hover:text-gray-800 hover:underline dark:hover:text-gray-300" 
        href="{{ route('filament.resources.moonguard/exceptions.index', ['tableFilters[sites][value]' => $site->id]) }}"
    >
        <span>Exceptions</span>
        <span>{{ $site->exception_logs_count }}</span>
    </a>
@endif
