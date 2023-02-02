<?php

namespace Taecontrol\Moonguard\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Taecontrol\Moonguard\Models\Site;
use Taecontrol\Moonguard\Contracts\MoonguardSite;
use Taecontrol\Moonguard\Repositories\SiteRepository;
use Taecontrol\Moonguard\Contracts\MoonguardExceptionLogGroup;
use Taecontrol\Moonguard\Events\ExceptionLogGroupCreatedEvent;
use Taecontrol\Moonguard\Events\ExceptionLogGroupUpdatedEvent;
use Taecontrol\Moonguard\Http\Requests\StoreExceptionLogRequest;
use Taecontrol\Moonguard\Repositories\ExceptionLogGroupRepository;

class ExceptionLogsController extends Controller
{
    public function __invoke(StoreExceptionLogRequest $request): JsonResponse
    {
        /** @var Site */
        $site = SiteRepository::query()
            ->where('api_token', $request->string('api_token'))
            ->first();

        abort_if(! $site, 403);

        /** @var MoonguardExceptionLogGroup|null $group */
        $group = ExceptionLogGroupRepository::query()
            ->where('file', $request->input('file'))
            ->where('type', $request->input('type'))
            ->where('line', $request->input('line'))
            ->first();

        if (! $group) {
            $group = $this->createExceptionLogGroup($request, $site);
        } else {
            $this->updateExceptionLogGroup($request, $group);
        }

        $group->exceptionLogs()->create(
            $request->safe()->except('api_token'),
        );

        return response()->json([
            'success' => true,
        ]);
    }

    protected function createExceptionLogGroup(StoreExceptionLogRequest $request, MoonguardSite $site)
    {
        $group = ExceptionLogGroupRepository::create([
            'message' => $request->input('message'),
            'type' => $request->input('type'),
            'file' => $request->input('file'),
            'line' => $request->input('line'),
            'first_seen' => $request->input('thrown_at'),
            'last_seen' => $request->input('thrown_at'),
            'site_id' => $site->id,
        ]);

        event(new ExceptionLogGroupCreatedEvent($group));

        return $group;
    }

    protected function updateExceptionLogGroup(StoreExceptionLogRequest $request, MoonguardExceptionLogGroup $group)
    {
        $timeInMinutesBetweenUpdates = config('moonguard.exceptions.notify_time_between_group_updates_in_minutes');
        $timeDiffInMinutesFromLastException = now()->diffInMinutes($group->last_seen);

        $group->update([
            'message' => $request->input('message'),
            'last_seen' => $request->input('thrown_at'),
        ]);

        if ($timeDiffInMinutesFromLastException > $timeInMinutesBetweenUpdates) {
            event(new ExceptionLogGroupUpdatedEvent($group));
        }
    }
}
