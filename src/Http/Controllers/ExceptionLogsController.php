<?php

namespace Taecontrol\Larastats\Http\Controllers;

use Taecontrol\Larastats\Http\Requests\StoreExceptionLogRequest;
use Taecontrol\Larastats\Repositories\SiteRepository;

class ExceptionLogsController extends Controller
{
    public function __invoke(StoreExceptionLogRequest $request)
    {
        $site = SiteRepository::query()
            ->where('api_token', $request->string('api_token'))
            ->first();

        abort_if(! $site, 403);

        $site->exceptionLogs()->create($request->validated());

        return response()->json([
            'success' => true,
        ]);
    }
}
