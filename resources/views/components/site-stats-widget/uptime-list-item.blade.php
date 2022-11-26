@if($site->uptimeCheck)
    <div class="flex items-center justify-between">
        <span class="text-gray-500">Uptime</span>
        @if(! $site->uptimeCheck?->is_enabled || ! $site->uptime_check_enabled)
            <span class="text-gray-400">Disabled</span>
        @elseif($site->uptimeCheck->status === \Taecontrol\Larastats\Enums\UptimeStatus::NOT_YET_CHECKED)
            <span class="rounded-full h-4 w-4 bg-gray-300"></span>
        @elseif($site->uptimeCheck->status === \Taecontrol\Larastats\Enums\UptimeStatus::UP)
            <span class="text-green-500 text-sm font-bold">UP</span>
        @else
            <span class="text-red-500 text-sm font-bold">DOWN</span>
        @endif
    </div>
@endif
