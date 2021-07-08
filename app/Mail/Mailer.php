<?php

namespace App\Mail;

use App\Mail\Contracts\Mailable;
use App\Mail\Contracts\MailerInterface;
use App\Mail\Contracts\MailerProviderInterface;

class Mailer implements MailerInterface
{
    private MailerProviderInterface $provider;

    public function __construct(MailerProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    public function send(Mailable $mailable): void
    {
        $this->provider->send($mailable);
    }
}
