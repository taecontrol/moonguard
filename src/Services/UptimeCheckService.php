<?php

namespace Taecontrol\Larastats\Services;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Taecontrol\Larastats\Contracts\LarastatsSite;
use Taecontrol\Larastats\Contracts\LarastatsUptimeCheck;
use Taecontrol\Larastats\Exceptions\InvalidPeriodException;
use Taecontrol\Larastats\Notifications\RequestTookLongerThanMaxDurationNotification;
use Taecontrol\Larastats\Notifications\UptimeCheckFailedNotification;
use Taecontrol\Larastats\Notifications\UptimeCheckRecoveredNotification;
use Taecontrol\Larastats\Repositories\UptimeCheckRepository;
use Taecontrol\Larastats\Repositories\UserRepository;
use Taecontrol\Larastats\ValueObjects\Period;

class UptimeCheckService
{
    protected LarastatsUptimeCheck $uptimeCheck;

    /**
     * @throws InvalidPeriodException
     */
    public function check(LarastatsSite $site, Response|Exception $response): void
    {
        if (! $site->uptimeCheck) {
            $this->uptimeCheck = UptimeCheckRepository::resolveModel();
            $this->uptimeCheck->site_id = $site->id;
            $this->uptimeCheck->status_last_change_date = now();
        } else {
            $this->uptimeCheck = $site->uptimeCheck;
        }

        if ($response instanceof Response) {
            $this->handleResponse($response);

            return;
        }

        $this->handleException($response);
    }

    /**
     * @throws InvalidPeriodException
     */
    protected function handleResponse(Response $response): void
    {
        if ($response->ok()) {
            $this->uptimeCheck->saveSuccessfulCheck($response);

            if ($this->uptimeCheck->was_failing) {
                $this->notifyUptimeWasRecovered();
            }

            if ($this->uptimeCheck->requestTookTooLong()) {
                $this->notifyRequestTookLongerThanMaxRequestDuration();
            }

            return;
        }

        $this->handleResponseError($response);
    }

    /**
     * @throws InvalidPeriodException
     */
    protected function handleResponseError(Response $response): void
    {
        $this->uptimeCheck->saveFailedCheck($response);

        if ($this->shouldNotifyAboutUptimeFailing()) {
            $this->updateFailedEventWasFiredTo(now());
            $this->notifyAboutDowntime();
        }
    }

    /**
     * @throws InvalidPeriodException
     */
    protected function handleException(Exception $exception): void
    {
        $this->uptimeCheck->saveFailedCheck($exception);

        if ($this->shouldNotifyAboutUptimeFailing()) {
            $this->updateFailedEventWasFiredTo(now());
            $this->notifyAboutDowntime();
        }
    }

    /**
     * @param Carbon|null $date
     *
     * @return void
     */
    protected function updateFailedEventWasFiredTo(?Carbon $date): void
    {
        $this->uptimeCheck->check_failed_event_fired_on_date = $date;
        $this->uptimeCheck->save();
        $this->uptimeCheck->refresh();
    }

    /**
     * @throws InvalidPeriodException
     *
     * @return void
     */
    protected function notifyUptimeWasRecovered(): void
    {
        $lastStatusChangeDate = $this->uptimeCheck->status_last_change_date ? clone $this->uptimeCheck->status_last_change_date : null;
        $downtimePeriod = new Period($lastStatusChangeDate, now());

        Notification::send(UserRepository::all(), new UptimeCheckRecoveredNotification($this->uptimeCheck, $downtimePeriod));

        $this->updateFailedEventWasFiredTo(null);
    }

    /**
     * @return void
     */
    protected function notifyRequestTookLongerThanMaxRequestDuration(): void
    {
        $maxRequestDuration = $this->uptimeCheck->site->max_request_duration_ms;

        Notification::send(
            UserRepository::all(),
            new RequestTookLongerThanMaxDurationNotification($this->uptimeCheck, $maxRequestDuration),
        );
    }

    /**
     * @throws InvalidPeriodException
     *
     * @return void
     */
    protected function notifyAboutDowntime(): void
    {
        $downtimePeriod = new Period($this->uptimeCheck->status_last_change_date, $this->uptimeCheck->last_check_date);
        Notification::send(UserRepository::all(), new UptimeCheckFailedNotification($this->uptimeCheck, $downtimePeriod));
    }

    protected function shouldNotifyAboutUptimeFailing(): bool
    {
        if ($this->uptimeCheck->check_times_failed_in_a_row === config('larastats.uptime_check.notify_failed_check_after_consecutive_failures')) {
            return true;
        }

        if (is_null($this->uptimeCheck->check_failed_event_fired_on_date)) {
            return false;
        }

        if ($this->uptimeCheck->check_failed_event_fired_on_date->diffInMinutes() >= config('larastats.uptime_check.resend_uptime_check_failed_notification_every_minutes')) {
            return true;
        }

        return false;
    }
}
