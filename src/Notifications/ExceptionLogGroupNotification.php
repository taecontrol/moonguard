<?php

namespace Taecontrol\MoonGuard\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Messages\SlackAttachment;
use Taecontrol\MoonGuard\Contracts\MoonGuardExceptionLogGroup;

class ExceptionLogGroupNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public MoonGuardExceptionLogGroup $exceptionLogGroup)
    {
    }

    public function via(): array
    {
        return config('moonguard.notifications.channels');
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->subject("[{$this->exceptionLogGroup->last_seen}]: {$this->exceptionLogGroup->type} | {$this->exceptionLogGroup->site->name}")
            ->greeting($this->exceptionLogGroup->type)
            ->line("Site: {$this->exceptionLogGroup->site->name}")
            ->line("Url: {$this->exceptionLogGroup->site->url}")
            ->line('Message: ')
            ->line($this->exceptionLogGroup->message)
            ->line("Seen at: {$this->exceptionLogGroup->last_seen->toDayDateTimeString()}")
            ->action('Review', $this->getActionUrl());
    }

    public function toSlack(): SlackMessage
    {
        $url = $this->getActionUrl();
        $footer = "{$this->exceptionLogGroup->site->name} | {$this->exceptionLogGroup->site->url}";

        return (new SlackMessage)
            ->error()
            ->attachment(
                fn (SlackAttachment $attachment) => $attachment
                    ->title($this->exceptionLogGroup->type, $url)
                    ->content($this->exceptionLogGroup->message)
                    ->footer($footer)
                    ->timestamp($this->exceptionLogGroup->last_seen)
            );
    }

    protected function getActionUrl(): string
    {
        return route('filament.moonguard.resources.exceptions.show', $this->exceptionLogGroup->id);
    }
}
