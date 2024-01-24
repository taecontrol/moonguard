@php
    $cpuLoad = $site->serverMetrics->first()->cpu_load ?? null;
    $ramUsage = $site->serverMetrics->first()->memory_usage ?? null;
    $diskUsage = $site->serverMetrics->first()->disk_usage['percentage'] ?? null;
@endphp


<a class="flex items-center justify-between text-gray-500 hover:text-gray-800 hover:underline dark:hover:text-gray-300"
    href="{{ route('filament.moonguard.resources.server-monitoring.index') }}">
    <span>Memory Usage</span>
    @if (isset($ramUsage))
        <span class="{{ $ramUsage > $site->ram_limit ? 'text-red-500' : 'text-green-500' }} font-bold text-sm">
            {{ $ramUsage . '%' }}
        </span>
    @else
        <span class="text-gray-500">---</span>
    @endif
</a>


<a class="flex items-center justify-between text-gray-500 hover:text-gray-800 hover:underline dark:hover:text-gray-300"
    href="{{ route('filament.moonguard.resources.server-monitoring.index') }}">
    <span>CPU Load</span>
    @if (isset($cpuLoad))
        <span class="{{ $cpuLoad > $site->cpu_limit ? 'text-red-500' : 'text-green-500' }} font-bold text-sm">
            {{ $cpuLoad . '%' }}
        </span>
    @else
        <span class="text-gray-500">---</span>
    @endif
</a>



<a class="flex items-center justify-between text-gray-500 hover:text-gray-800 hover:underline dark:hover:text-gray-300"
    href="{{ route('filament.moonguard.resources.server-monitoring.index') }}">
    <span>Total Disk Used</span>
    @if (isset($diskUsage))
        <span class="{{ $diskUsage > $site->disk_limit ? 'text-red-500' : 'text-green-500' }} font-bold text-sm">
            {{ $diskUsage . '%' }}
        </span>
    @else
        <span class="text-gray-500">---</span>
    @endif
</a>
