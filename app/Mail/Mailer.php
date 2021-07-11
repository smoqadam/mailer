<?php

namespace App\Mail;

use App\Jobs\MailSend;
use App\Mail\Contracts\EmailProvider;
use App\Mail\Contracts\Mailable;
use App\Mail\Contracts\MailerInterface;
use App\Mail\Exceptions\MailerException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Psr\Log\LoggerInterface;

class Mailer implements MailerInterface
{
    use DispatchesJobs;
    private ?EmailProvider $provider;
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger, ?EmailProvider $provider = null)
    {
        $this->logger = $logger;
        $this->provider = $provider;
    }

    public function setProvider(EmailProvider $provider): void
    {
        $this->provider = $provider;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
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
            $this->logger->error($this->provider->error(), $mailable->toArray());
            throw new MailerException($this->provider->error());
        }

        $this->logger->info(sprintf('email sent successfully by %s', get_class($this->provider)), $mailable->toArray());
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
