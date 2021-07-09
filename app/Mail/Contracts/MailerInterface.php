<?php

namespace App\Mail\Contracts;

interface MailerInterface
{
    public function send(Mailable $mailable): void;

    public function setProvider(EmailProvider $provider);
}
