<?php

namespace App\Mail\Contracts;

interface MailerProviderInterface
{
    public function send(Mailable $mail);
}
