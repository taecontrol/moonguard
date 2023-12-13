<?php

namespace Taecontrol\MoonGuard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Taecontrol\MoonGuard\Models\Site;
use Taecontrol\MoonGuard\Models\SystemMetric;
use Taecontrol\MoonGuard\Contracts\MoonGuardSite;
use Taecontrol\MoonGuard\Events\SystemMetricEvent;
use Taecontrol\MoonGuard\Repositories\SiteRepository;

class SystemMetricsController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        /** @var Site */
        $site = SiteRepository::query()
            ->where('api_token', $request->input('api_token'))
            ->first();

        abort_if(! $site, 403);

        SystemMetric::create([
            'cpu_usage' => $request->input('cpuLoad'),
            'memory_usage' => $request->input('memory'),
            'disk_usage' => json_encode($request->input('disk')),
            'disk_usage_percentage' => $this->calculateDiskUsagePercentage($request),
            'site_id' => $site->id,
        ]);

        $this->checkLimits($site, $request);

        return response()->json([
            'success' => true,
        ]);
    }

    private function calculateDiskUsagePercentage(Request $request)
    {
        $diskUsage = $request->input('disk');
        $freeSpace = $diskUsage ? $diskUsage['freeSpace'] : null;
        $totalSpace = $diskUsage ? $diskUsage['totalSpace'] : null;

        $percentage = $totalSpace ? ($totalSpace - $freeSpace) / $totalSpace * 100 : 0;

        return number_format($percentage, 2);
    }

    private function checkLimits(MoonGuardSite $site, Request $request)
    {
        $cpuLimit = $site->getCpuLimit();
        $ramLimit = $site->getRamLimit();
        $diskLimit = $site->getDiskLimit();

        $cpuLoad = $request->input('cpuLoad');
        $memory = $request->input('memory');
        $diskUsagePercentage = $this->calculateDiskUsagePercentage($request);

        if ($cpuLoad > $cpuLimit) {
            $event = new SystemMetricEvent($site, 'cpu', $cpuLoad, $site->monitoring_notification_enabled);
            event($event);
        }

        if ($memory > $ramLimit) {
            $event = new SystemMetricEvent($site, 'ram', $memory, $site->monitoring_notification_enabled);
            event($event);
        }

        if ($diskUsagePercentage > $diskLimit) {
            $event = new SystemMetricEvent($site, 'disk', $diskUsagePercentage, $site->monitoring_notification_enabled);
            event($event);
        }
    }
}
