<?php

namespace App\Mail;

use App\Mail\Contracts\Mailable;
use App\Mail\Contracts\MailerInterface;
use App\Mail\Contracts\MailerProviderInterface;
use App\Mail\Contracts\ValidationInterface;

class Mailer implements MailerInterface
{
    private MailerProviderInterface $provider;
    private ValidationInterface $validation;

    public function __construct(MailerProviderInterface $provider, ValidationInterface $validation)
    {
        $this->provider = $provider;
        $this->validation = $validation;
    }

    public function send(Mailable $mailable): void
    {
        try {
            $this->validate($mailable);
            $this->provider->send($mailable);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function validate(Mailable $mailable): bool
    {
        return $this->validation->validate($mailable);
    }
}
