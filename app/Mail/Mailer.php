<?php

namespace App\Mail;

use App\Mail\Contracts\Mailable;
use App\Mail\Contracts\MailerInterface;
use App\Mail\Exceptions\MailerException;

class Mailer implements MailerInterface
{
    private ?AbstractProvider $provider;

    public function __construct(?AbstractProvider $provider = null)
    {
        $this->provider = $provider;
    }

    public function send(Mailable $mailable): void
    {
        if (!$this->provider instanceof AbstractProvider) {
            throw new \InvalidArgumentException('provider is null');
        }

        $response = $this->getProvider()->send($mailable);

        if ($response->getStatusCode() != 200) {
            throw new MailerException(sprintf('mail send failed: %s', $response->getContent(false)));
        }
    }

    public function setProvider(AbstractProvider $provider): void
    {
        $this->provider = $provider;
    }

    public function getProvider(): AbstractProvider
    {
        return $this->provider;
    }
}
