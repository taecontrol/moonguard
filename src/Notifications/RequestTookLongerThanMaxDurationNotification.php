<?php

namespace Taecontrol\MoonGuard\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Messages\SlackAttachment;
use Taecontrol\MoonGuard\ValueObjects\RequestDuration;
use Taecontrol\MoonGuard\Contracts\MoonGuardUptimeCheck;

class RequestTookLongerThanMaxDurationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public MoonGuardUptimeCheck $uptimeCheck, public RequestDuration $maxRequestDuration)
    {
    }

    public function via(): array
    {
        return config('moonguard.notifications.channels');
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->success()
            ->subject($this->getMessageText())
            ->line($this->getMessageText())
            ->line($this->uptimeCheck->site->name);
    }

    public function toSlack(): SlackMessage
    {
        return (new SlackMessage)
            ->warning()
            ->attachment(
                fn (SlackAttachment $attachment) => $attachment
                    ->title($this->getMessageText())
                    ->fallback($this->getMessageText())
                    ->footer($this->uptimeCheck->site->name)
                    ->timestamp(now())
            );
    }

    protected function getMessageText(): string
    {
        return "{$this->uptimeCheck->site->url} request took longer than {$this->maxRequestDuration->toMilliseconds()} (took {$this->uptimeCheck->request_duration_ms->toMilliseconds()})";
    }
}
