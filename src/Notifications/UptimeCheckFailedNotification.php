<?php

namespace Taecontrol\Larastats\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Taecontrol\Larastats\ValueObjects\Period;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Messages\SlackAttachment;
use Taecontrol\Larastats\Contracts\LarastatsUptimeCheck;

class UptimeCheckFailedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public LarastatsUptimeCheck $uptime, Period $downtimePeriod)
    {
    }

    public function via(): array
    {
        return config('larastats.notifications.channels');
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->error()
            ->subject($this->getMessageText())
            ->line($this->getMessageText())
            ->line($this->uptime->site->name);
    }

    public function toSlack(): SlackMessage
    {
        return (new SlackMessage)
            ->success()
            ->attachment(
                fn (SlackAttachment $attachment) => $attachment
                    ->title($this->getMessageText())
                    ->fallback($this->getMessageText())
                    ->footer($this->uptime->site->name)
                    ->timestamp(now())
            );
    }

    protected function getMessageText(): string
    {
        return "{$this->uptime->site->url} seems down";
    }
}
