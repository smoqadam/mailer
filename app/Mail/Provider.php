<?php

namespace App\Mail;

use App\Mail\Contracts\EmailProvider;

abstract class Provider implements EmailProvider
{
    protected string $error;

    public function error(): string
    {
        return $this->error;
    }
}
