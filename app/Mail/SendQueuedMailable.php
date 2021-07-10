<?php

namespace App\Mail;

use App\Mail\Contracts\EmailProvider;
use App\Mail\Contracts\Mailable as MailableContract;
use App\Mail\Contracts\MailerInterface;
use Illuminate\Support\Facades\Log;

class SendQueuedMailable
{
    private ProviderCollection $providers;

    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->providers = new ProviderCollection();
        $this->mailer = $mailer;
    }

    public function getProviders(): ProviderCollection
    {
        return $this->providers;
    }

    public function setProviders(ProviderCollection $providers): self
    {
        $this->providers = $providers;

        return $this;
    }

    public function addProvider(EmailProvider $provider): self
    {
        $this->providers[] = $provider;

        return $this;
    }

    public function getMailer(): MailerInterface
    {
        return $this->mailer;
    }

    /**
     * Receives a Mailable object and try to send the email by provided email providers. Return false if all
     * providers failed
     *
     * @param MailableContract $mailable
     * @return bool
     */
    public function send(MailableContract $mailable): bool
    {
        if (!count($this->providers)) {
            throw new \InvalidArgumentException('Providers are empty. Please set at least one provider');
        }
        foreach ($this->providers as $provider) {
            try {
                $this->mailer->setProvider($provider);
                $this->mailer->send($mailable);
                Log::info('success');
                return true;
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }

        return false;
    }
}
