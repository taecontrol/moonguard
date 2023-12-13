<?php

namespace Taecontrol\MoonGuard\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Taecontrol\MoonGuard\Contracts\MoonGuardSite;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Messages\SlackAttachment;

class SystemMetricNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public MoonGuardSite $site;

    public string $resource;

    public array | string $usage;

    public string $channel;

    public function __construct($site, $resource, $usage, $channel)
    {
        $this->site = $site;
        $this->resource = $resource;
        $this->usage = $usage;
        $this->channel = $channel;
    }

    public function via($notifiable): string
    {
        return $this->channel;
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Resource usage alert')
            ->greeting("{$this->site->name}")
            ->line("url: {$this->site->url}")
            ->line("The established {$this->resource} usage limit has been reached at {$this->usage}%.");
    }

    public function toSlack($notifiable): SlackMessage
    {
        return (new SlackMessage)
            ->error()
            ->attachment(
                fn (SlackAttachment $attachment) => $attachment
                    ->title('Resource usage alert', $this->site->name)
                    ->content("The {$this->site->name} site has reached a usage rate of {$this->usage}% on {$this->resource}.")
                    ->footer("{$this->site->name} | {$this->site->url}")
                    ->timestamp(now())
            );
    }
}
