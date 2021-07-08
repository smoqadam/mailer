<?php

namespace App\Mail;

use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractMailer
{
    protected HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    abstract public function send(Mailable $mailable);
}
