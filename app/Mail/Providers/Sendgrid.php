<?php

namespace App\Mail\Providers;

use App\Mail\Contracts\EmailProvider;
use App\Mail\Contracts\Mailable;
use Illuminate\Support\Facades\Log;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Sendgrid implements EmailProvider
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function send(Mailable $mailable): bool
    {
        $response = $this->httpClient->request('POST', 'https://api.sendgrid.com/v3/mail/send', [
            'json' => $this->getPayload($mailable),
            'auth_bearer' => $this->getApiKey(),
        ]);
        if (202 != $response->getStatusCode()) {
            return false;
        }

        return true;
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

    private function getApiKey()
    {
        return env('SENDGRID_API_KEY');
    }
}
