<?php

namespace Taecontrol\Larastats\Http\Controllers;

use Taecontrol\Larastats\Contracts\LarastatsExceptionLogGroup;
use Taecontrol\Larastats\Http\Requests\StoreExceptionLogRequest;
use Taecontrol\Larastats\Repositories\ExceptionLogGroupRepository;
use Taecontrol\Larastats\Repositories\SiteRepository;

class ExceptionLogsController extends Controller
{
    public function __invoke(StoreExceptionLogRequest $request)
    {
        $site = SiteRepository::query()
            ->where('api_token', $request->string('api_token'))
            ->first();

        abort_if(! $site, 403);

        /** @var LarastatsExceptionLogGroup|null $group */
        $group = ExceptionLogGroupRepository::query()
            ->where('file', $request->input('file'))
            ->where('type', $request->input('type'))
            ->where('line', $request->input('line'))
            ->first();

        if (! $group) {
            $group = ExceptionLogGroupRepository::create([
                'message' => $request->input('message'),
                'type' => $request->input('type'),
                'file' => $request->input('file'),
                'line' => $request->input('line'),
                'first_seen' => $request->input('thrown_at'),
                'last_seen' => $request->input('thrown_at'),
                'site_id' => $site->id,
            ]);
        } else {
            $group->update([
                'message' => $request->input('message'),
                'last_seen' => $request->input('thrown_at'),
            ]);
        }
        $site->exceptionLogs()->create(
            array_merge(
                ['exception_log_group_id' => $group->id],
                $request->validated()
            )
        );

        return response()->json([
            'success' => true,
        ]);
    }
}
