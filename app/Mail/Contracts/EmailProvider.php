<?php

namespace App\Mail\Contracts;

use App\Mail\Contracts\Mailable as MailableContract;

interface EmailProvider
{
    public function send(MailableContract $mailable): bool;

    public function error(): string;
}
