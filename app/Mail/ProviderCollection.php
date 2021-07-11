<?php

namespace App\Mail;

use App\Collection\Collection;
use App\Mail\Contracts\EmailProvider;

class ProviderCollection extends Collection
{
    public function __construct(array $data = [])
    {
        parent::__construct(EmailProvider::class, $data);
    }
}
