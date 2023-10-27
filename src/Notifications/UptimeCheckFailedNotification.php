<?php

namespace Taecontrol\MoonGuard\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Taecontrol\MoonGuard\ValueObjects\Period;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Messages\SlackAttachment;
use Taecontrol\MoonGuard\Contracts\MoonGuardUptimeCheck;

class UptimeCheckFailedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public MoonGuardUptimeCheck $uptime,
        Period $downtimePeriod,
        public String $channel
    ) {
    }

    public function via(): string
    {
        return $this->channel;
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
            ->error()
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
