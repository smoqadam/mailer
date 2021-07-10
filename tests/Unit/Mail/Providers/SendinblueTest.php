<?php

namespace Tests\Unit\Mail\Providers;

use App\Mail\Providers\Sendgrid;
use App\Mail\Providers\Sendinblue;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Tests\TestCase;

class SendinblueTest extends TestCase
{
    public function testSendSuccessfully()
    {
        $provider = new Sendinblue(new MockHttpClient([
            new MockResponse('', ['http_code' => 201]),
        ]));
        $result = $provider->send($this->createMailable());
        $this->assertTrue($result);
    }

    public function testSendFail()
    {
        $provider = new Sendinblue(new MockHttpClient([
            new MockResponse('', ['http_code' => 500]),
        ]));
        $result = $provider->send($this->createMailable());
        $this->assertFalse($result);
    }
}
