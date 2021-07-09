<?php

namespace App\Mail;

use App\Mail\Contracts\Mailable as MailableContract;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class AbstractProvider
{
    protected HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    abstract public function send(MailableContract $mailable): ResponseInterface;
}
