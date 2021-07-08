<?php

namespace App\Mail;

use App\Mail\Contracts\Mailable;
use App\Mail\Contracts\ValidationInterface;
use App\Mail\Exceptions\ValidationException;

class Validation implements ValidationInterface
{
    public function validate(Mailable $mailable): bool
    {
        if (!$this->isEmail($mailable->getEmail())) {
            throw new ValidationException('Email format is not correct');
        }

        if ($this->isNull($mailable->getSubject())) {
            throw new ValidationException('Subject cannot be null');
        }

        /// other validation can be added here...
        ///
        return true;
    }

    private function isEmail($email): bool
    {
        return preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/', $email);
    }

    private function isNull($value): bool
    {
        return is_null($value);
    }
}
