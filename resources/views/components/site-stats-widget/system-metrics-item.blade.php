@php
    $systemMetric = $site
        ->systemMetrics()
        ->latest()
        ->first();
    $cpuUsage = $ramUsage = $diskUsage = null;
    if ($systemMetric) {
        $cpuUsage = $systemMetric->cpu_usage;
        $ramUsage = $systemMetric->memory_usage;
        $diskUsage = $systemMetric->disk_usage_percentage;
    }
@endphp

@if (isset($ramUsage))
    <a class="flex items-center justify-between text-gray-500 hover:text-gray-800 hover:underline dark:hover:text-gray-300"
        href="{{ route('filament.moonguard.resources.monitorings.index') }}">
        <span>Memory Usage</span>
        <span class="{{ $ramUsage > $site->getRamLimit() ? 'text-red-500' : 'text-green-500' }}">
            {{ $ramUsage . '%' }}
        </span>
    </a>
@else
    <div class="flex items-center justify-between text-gray-500">
        <span>Memory Usage</span>
        <span class="text-gray-600">No Data</span>
    </div>
@endif

@if (isset($cpuUsage))
    <a class="flex items-center justify-between text-gray-500 hover:text-gray-800 hover:underline dark:hover:text-gray-300"
        href="{{ route('filament.moonguard.resources.monitorings.index') }}">
        <span>CPU Usage</span>
        <span class="{{ $cpuUsage > $site->getCpuLimit() ? 'text-red-500' : 'text-green-500' }}">
            {{ $cpuUsage . '%' }}
        </span>
    </a>
@else
    <div class="flex items-center justify-between text-gray-500">
        <span>CPU Usage</span>
        <span class="text-gray-600">No Data</span>
    </div>
@endif


@if (isset($diskUsage))
    <a class="flex items-center justify-between text-gray-500 hover:text-gray-800 hover:underline dark:hover:text-gray-300"
        href="{{ route('filament.moonguard.resources.monitorings.index') }}">
        <span>Total Disk Used</span>
        <span class="{{ $diskUsage > $site->getDiskLimit() ? 'text-red-500' : 'text-green-500' }}">
            {{ $diskUsage . '%' }}
        </span>
    </a>
@else
    <div class="flex items-center justify-between text-gray-500">
        <span>Disk Usage</span>
        <span class="text-gray-600">No Data</span>
    </div>
@endif


@if (!$site->monitoring_notification_enabled)
    <div class="flex items-center justify-between text-gray-500">
        <span>Monitoring Health</span>
        <span class="text-gray-600">Disabled</span>
    </div>
@else
    <a class="flex items-center justify-between text-gray-500">
        <span>Monitoring Health</span>
        <span class="text-green-500">Enabled</span>
    </a>
@endif
