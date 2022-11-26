<div class="flex items-center justify-between">
    <span class="text-gray-500">Performance</span>
    @if(! $site->uptimeCheck)
        <span class="text-gray-500">---</span>
    @elseif(! $site->uptimeCheck?->is_enabled || ! $site->uptime_check_enabled)
        <span class="text-gray-400">Disabled</span>
    @elseif($site->uptimeCheck->status === \Taecontrol\Larastats\Enums\UptimeStatus::NOT_YET_CHECKED)
        <span class="text-gray-500">---</span>
    @elseif($site->uptimeCheck->status === \Taecontrol\Larastats\Enums\UptimeStatus::UP)
        <span
            class="text-green-500 text-sm font-bold">{{ $site->uptimeCheck->request_duration_ms->toMilliseconds() }}</span>
    @else
        <span class="text-red-500">{{ $site->uptimeCheck->request_duration_ms->noValue() }}</span>
    @endif
</div>
