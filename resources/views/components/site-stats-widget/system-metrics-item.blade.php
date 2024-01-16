@php
    $systemMetric = $site
        ->systemMetrics()
        ->latest()
        ->first();
    $cpuUsage = $ramUsage = $diskUsage = null;
    if ($systemMetric) {
        $cpuUsage = $systemMetric->cpu_usage;
        $ramUsage = $systemMetric->memory_usage;
        $diskUsage = $systemMetric->disk_usage['percentage'];
    }
@endphp

@if (isset($ramUsage))
    <a class="flex items-center justify-between text-gray-500 hover:text-gray-800 hover:underline dark:hover:text-gray-300"
        href="{{ route('filament.moonguard.resources.system-monitoring.index') }}">
        <span>Memory Usage</span>
        <span class="{{ $ramUsage > $site->ram_limit ? 'text-red-500' : 'text-green-500' }}">
            {{ $ramUsage . '%' }}
        </span>
    </a>
@else
    <div class="flex items-center justify-between text-gray-500">
        <span>Memory Usage</span>
        <span class="text-gray-500">---</span>
    </div>
@endif

@if (isset($cpuUsage))
    <a class="flex items-center justify-between text-gray-500 hover:text-gray-800 hover:underline dark:hover:text-gray-300"
        href="{{ route('filament.moonguard.resources.system-monitoring.index') }}">
        <span>CPU Usage</span>
        <span class="{{ $cpuUsage > $site->cpu_limit ? 'text-red-500' : 'text-green-500' }}">
            {{ $cpuUsage . '%' }}
        </span>

    </a>
@else
    <div class="flex items-center justify-between text-gray-500">
        <span>CPU Usage</span>
        <span class="text-gray-500">---</span>
    </div>
@endif


@if (isset($diskUsage))
    <a class="flex items-center justify-between text-gray-500 hover:text-gray-800 hover:underline dark:hover:text-gray-300"
        href="{{ route('filament.moonguard.resources.system-monitoring.index') }}">
        <span>Total Disk Used</span>
        <span class="{{ $diskUsage > $site->disk_limit ? 'text-red-500' : 'text-green-500' }}">
            {{ $diskUsage . '%' }}
        </span>

    </a>
@else
    <div class="flex items-center justify-between text-gray-500">
        <span>Disk Usage</span>
        <span class="text-gray-500">---</span>
    </div>
@endif
