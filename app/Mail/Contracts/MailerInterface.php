<?php

namespace App\Mail\Contracts;

use App\Mail\AbstractProvider;

interface MailerInterface
{
    public function send(Mailable $mailable): void;

    public function setProvider(AbstractProvider $provider);
}
