@if(! \Taecontrol\Larastats\Repositories\ExceptionLogRepository::isEnabled())
    <div class="flex items-center justify-between text-gray-500">
        <span>Exceptions</span>
        <span class="text-gray-400">Disabled</span>
    </div>
@else
    <a class="flex items-center justify-between text-gray-500 hover:underline hover:text-gray-800" href="{{ route('filament.resources.larastats/exceptions.index', ['tableFilters[sites][value]' => $site->id]) }}">
        <span>Exceptions</span>
        <span>{{ $site->exception_logs_count }}</span>
    </a>
@endif
