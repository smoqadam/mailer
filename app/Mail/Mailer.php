<?php

namespace App\Mail;

use App\Mail\Contracts\EmailProvider;
use App\Mail\Contracts\Mailable;
use App\Mail\Contracts\MailerInterface;
use App\Mail\Exceptions\MailerException;

class Mailer implements MailerInterface
{
    private ?EmailProvider $provider;

    public function __construct(?EmailProvider $provider = null)
    {
        $this->provider = $provider;
    }

    public function send(Mailable $mailable): void
    {
        if (!$this->provider instanceof EmailProvider) {
            throw new \InvalidArgumentException('provider is null');
        }
        if (!$this->provider->send($mailable)) {
            throw new MailerException('mail send failed');
        }
    }

    public function setProvider(EmailProvider $provider): void
    {
        $this->provider = $provider;
    }
}
