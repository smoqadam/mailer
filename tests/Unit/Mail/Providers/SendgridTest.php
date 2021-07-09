<?php

namespace Tests\Unit\Mail\Providers;

use App\Mail\Providers\Sendgrid;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Tests\TestCase;

class SendgridTest extends TestCase
{
    public function testSendSuccessfully()
    {
        $provider = new Sendgrid(new MockHttpClient());
        $result = $provider->send($this->createMailable());
        $this->assertTrue($result);
    }

    public function testSendFail()
    {
        $provider = new Sendgrid(new MockHttpClient([
            new MockResponse('', ['http_code' => 500]),
        ]));
        $result = $provider->send($this->createMailable());
        $this->assertFalse($result);
    }
}
