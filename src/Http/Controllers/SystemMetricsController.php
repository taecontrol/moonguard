<?php

namespace Taecontrol\MoonGuard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Taecontrol\MoonGuard\Models\Site;
use Taecontrol\MoonGuard\Models\SystemMetric;
use Taecontrol\MoonGuard\Contracts\MoonGuardSite;
use Taecontrol\MoonGuard\Repositories\SiteRepository;
use Taecontrol\MoonGuard\Events\SystemMetricAlertEvent;

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
            'site_id' => $site->id,
        ]);

        $this->checkLimits($site, $request);

        return response()->json([
            'success' => true,
        ]);
    }

    private function checkLimits(MoonGuardSite $site, Request $request)
    {
        $cpuLimit = $site->cpu_limit;
        $ramLimit = $site->ram_limit;
        $diskLimit = $site->disk_limit;

        $cpuLoad = $request->input('cpuLoad');
        $memory = $request->input('memory');
        $systemMetric = SystemMetric::where('site_id', $site->id)->first();
        $diskUsagePercentage = floatval($systemMetric->disk_usage);

        if ($cpuLoad >= $cpuLimit) {
            $event = new SystemMetricAlertEvent($site, 'cpu', $cpuLoad, $site->hardware_monitoring_notification_enabled);
            event($event);
        }

        if ($memory >= $ramLimit) {
            $event = new SystemMetricAlertEvent($site, 'ram', $memory, $site->hardware_monitoring_notification_enabled);
            event($event);
        }

        if ($diskUsagePercentage >= $diskLimit) {
            $event = new SystemMetricAlertEvent($site, 'disk', $diskUsagePercentage, $site->hardware_monitoring_notification_enabled);
            event($event);
        }
    }
}
