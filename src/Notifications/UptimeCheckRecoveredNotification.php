<?php

namespace Taecontrol\Larastats\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Messages\SlackAttachment;
use Taecontrol\Larastats\Contracts\LarastatsUptimeCheck;
use Taecontrol\Larastats\ValueObjects\Period;

class UptimeCheckRecoveredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public LarastatsUptimeCheck $uptime, public Period $downtimePeriod)
    {
    }

    public function via(): array
    {
        return ['mail', 'slack'];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->success()
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
        return "{$this->uptime->site->url} has recovered after {$this->downtimePeriod->duration()}";
    }
}
