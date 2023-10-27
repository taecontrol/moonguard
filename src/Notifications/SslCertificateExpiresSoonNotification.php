<?php

namespace Taecontrol\MoonGuard\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Messages\SlackAttachment;
use Taecontrol\MoonGuard\Contracts\MoonGuardSslCertificateCheck;

class SslCertificateExpiresSoonNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public MoonGuardSslCertificateCheck $sslCertificateCheck,
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
            ->line($this->sslCertificateCheck->site->name);
    }

    public function toSlack(): SlackMessage
    {
        return (new SlackMessage)
            ->warning()
            ->attachment(
                fn (SlackAttachment $attachment) => $attachment
                    ->title($this->getMessageText())
                    ->content("Expires {$this->sslCertificateCheck->expiration_date->diffForHumans()}")
                    ->fallback($this->getMessageText())
                    ->footer($this->sslCertificateCheck->site->name)
                    ->timestamp(now())
            );
    }

    protected function getMessageText(): string
    {
        return "SSL certificate for {$this->sslCertificateCheck->site->url} expires soon";
    }
}
