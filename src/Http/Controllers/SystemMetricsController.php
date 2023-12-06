<?php

namespace Taecontrol\MoonGuard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Taecontrol\MoonGuard\Models\Site;
use Taecontrol\MoonGuard\Models\SystemMetric;
use Taecontrol\MoonGuard\Repositories\SiteRepository;

class SystemMetricsController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        /** @var Site */
        $site = SiteRepository::query()
            ->where('api_token', $request->string('api_token'))
            ->first();

        abort_if(! $site, 403);

        SystemMetric::create([
            'cpu_usage' => $request->input('cpu_usage'),
            'memory_usage' => $request->input('memory_usage'),
            'disk_usage' => $request->input('disk_usage'),
            'site_id' => $site->id,
        ]);

        return response()->json([
            'success' => true,
        ]);
    }
}
