<?php

namespace App\Mail;

use App\Mail\Contracts\Mailable as MailableContract;

class Mailable implements MailableContract
{
    use MailableTrait;
}
