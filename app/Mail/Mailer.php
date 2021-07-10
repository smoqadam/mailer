<?php

namespace App\Mail;

use App\Jobs\MailSend;
use App\Mail\Contracts\EmailProvider;
use App\Mail\Contracts\Mailable;
use App\Mail\Contracts\MailerInterface;
use App\Mail\Exceptions\MailerException;
use Illuminate\Foundation\Bus\DispatchesJobs;

class Mailer implements MailerInterface
{
    use DispatchesJobs;
    private ?EmailProvider $provider;

    public function __construct(?EmailProvider $provider = null)
    {
        $this->provider = $provider;
    }

    public function setProvider(EmailProvider $provider): void
    {
        $this->provider = $provider;
    }

    /**
     * Receives a Mailable and sends it
     *
     * @param Mailable $mailable
     * @throws MailerException
     */
    public function send(Mailable $mailable): void
    {
        if (!$this->provider instanceof EmailProvider) {
            throw new \InvalidArgumentException('provider is null');
        }
        if (!$this->provider->send($mailable)) {
            throw new MailerException($this->provider->error());
        }
    }

    /**
     * Add a Mailable object to the queue
     *
     * @param Mailable $mailable
     */
    public function queue(Mailable $mailable)
    {
        MailSend::dispatch($mailable);
    }
}
