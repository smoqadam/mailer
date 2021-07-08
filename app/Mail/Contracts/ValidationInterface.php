<?php

namespace App\Mail\Contracts;

interface ValidationInterface
{
    public function validate(Mailable $mailable): bool;
}
