<?php

namespace Taecontrol\MoonGuard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Taecontrol\MoonGuard\Models\Site;
use Taecontrol\MoonGuard\Models\ServerMetric;
use Taecontrol\MoonGuard\Contracts\MoonGuardSite;
use Taecontrol\MoonGuard\Repositories\SiteRepository;
use Taecontrol\MoonGuard\Events\ServerMetricAlertEvent;

class ServerMetricsController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        /** @var Site */
        $site = SiteRepository::query()
            ->where('api_token', $request->input('api_token'))
            ->first();

        abort_if(! $site, 403);

        $systemMetric = ServerMetric::create([
            'cpu_load' => $request->input('cpuLoad'),
            'memory_usage' => $request->input('memory'),
            'disk_usage' => json_encode($request->input('disk')),
            'site_id' => $site->id,
        ]);

        $cpuLoad = $request->input('cpuLoad');
        $memory = $request->input('memory');
        $diskUsagePercentage = $systemMetric->disk_usage['percentage'];

        $this->checkLimits($site, $cpuLoad, $memory, $diskUsagePercentage);

        return response()->json([
            'success' => true,
        ]);
    }

    private function checkLimits(MoonGuardSite $site, int $cpuLoad, int $memory, float $diskUsagePercentage)
    {
        $cpuLimit = $site->cpu_limit;
        $ramLimit = $site->ram_limit;
        $diskLimit = $site->disk_limit;

        if ($cpuLoad >= $cpuLimit) {
            $event = new ServerMetricAlertEvent($site, 'cpu', $cpuLoad, $site->hardware_monitoring_notification_enabled);
            event($event);
        }

        if ($memory >= $ramLimit) {
            $event = new ServerMetricAlertEvent($site, 'ram', $memory, $site->hardware_monitoring_notification_enabled);
            event($event);
        }

        if ($diskUsagePercentage >= $diskLimit) {
            $event = new ServerMetricAlertEvent($site, 'disk', $diskUsagePercentage, $site->hardware_monitoring_notification_enabled);
            event($event);
        }
    }
}
