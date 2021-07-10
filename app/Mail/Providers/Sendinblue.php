<?php

namespace App\Mail\Providers;

use App\Mail\Contracts\Mailable;
use App\Mail\Provider;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Sendinblue extends Provider
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function send(Mailable $mailable): bool
    {
        $response = $this->httpClient->request('POST', 'https://api.sendinblue.com/v3/smtp/email', [
            'json' => $this->getPayload($mailable),
            'headers' => $this->getHeaders(),
        ]);

        if (201 != $response->getStatusCode()) {
            $this->error = $response->getContent(false);

            return false;
        }

        return true;
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
            'api-key' => env('SENDINBLUE_API_KEY'),
        ];
    }
}
