<?php

namespace App\Mail\Providers;

use App\Mail\AbstractProvider;
use App\Mail\Contracts\Mailable;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class Sendinblue extends AbstractProvider
{
    private string $apiKey;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->apiKey = env('SENDINBLUE_API_KEY');
        parent::__construct($httpClient);
    }

    public function send(Mailable $mailable):ResponseInterface
    {
        return $this->httpClient->request('POST', 'https://api.sendinblue.com/v3/smtp/email', [
            'json' => $this->getPayload($mailable),
            'headers' => $this->getHeaders(),
        ]);
    }

    private function getPayload(Mailable $mailable): array
    {
        return [
            'sender' => [
                'name' => env('MAIL_FROM_NAME'),
                'email' => env('MAIL_FROM_ADDRESS'),
            ],
            'to' => [
                [
                    'email' => $mailable->getEmail(),
                    'name' => $mailable->getName(),
                ],
            ],
            'subject' => $mailable->getSubject(),
            'htmlContent' => $mailable->getBody(),
        ];
    }

    private function getHeaders(): array
    {
        return [
            'api-key' => $this->apiKey,
        ];
    }
}
