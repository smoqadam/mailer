<?php

namespace App\Mail\Providers;

use App\Mail\AbstractProvider;
use App\Mail\Contracts\Mailable;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class Sendgrid extends AbstractProvider
{
    private string $apiKey;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->apiKey = env('SENDGRID_API_KEY');
        parent::__construct($httpClient);
    }

    public function send(Mailable $mailable): ResponseInterface
    {
        return $this->httpClient->request('POST', 'https://api.sendgrid.com/v3/mail/send', [
            'json' => $this->getPayload($mailable),
            'auth_bearer' => $this->apiKey,
        ]);
    }

    private function getPayload(Mailable $mailable): array
    {
        $payload = [
            'personalizations' => [],
            'reply_to' => [
                'email' => env('MAIL_FROM_ADDRESS'),
                'name' => env('MAIL_FROM_NAME'),
            ],
            'from' => [
                'email' => env('MAIL_FROM_ADDRESS'),
                'name' => env('MAIL_FROM_NAME'),
            ],
            'subject' => $mailable->getSubject(),
        ];
        $payload['content'][] = [
            'type' => $mailable->isHtml() ? 'text/html' : 'text/plain',
            'value' => $mailable->getBody(),
        ];
        $payload['personalizations'][] = [
            'to' => [
                [
                    'email' => $mailable->getEmail(),
                    'name' => $mailable->getName(),
                ],
            ],
        ];

        return $payload;
    }
}
