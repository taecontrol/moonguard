<?php

namespace Taecontrol\Larastats\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Messages\SlackAttachment;
use Taecontrol\Larastats\Contracts\LarastatsExceptionLogGroup;

class NewExceptionLogGroupNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public LarastatsExceptionLogGroup $exceptionLogGroup)
    {
    }

    public function via(): array
    {
        return config('larastats.notifications.channels');
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->subject("{$this->exceptionLogGroup->site->name} | {$this->exceptionLogGroup->type} | {$this->exceptionLogGroup->last_seen}")
            ->greeting('The following exception was catched:')
            ->line($this->exceptionLogGroup->message)
            ->line("{$this->exceptionLogGroup->site->name} | {$this->exceptionLogGroup->last_seen}");
    }

    public function toSlack(): SlackMessage
    {
        return (new SlackMessage)
            ->warning()
            ->attachment(
                fn (SlackAttachment $attachment) => $attachment
                    ->title($this->exceptionLogGroup->type)
                    ->fallback($this->exceptionLogGroup->message)
                    ->footer($this->exceptionLogGroup->site->name)
                    ->timestamp($this->exceptionLogGroup->last_seen)
            );
    }
}
