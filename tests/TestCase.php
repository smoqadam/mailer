<?php

namespace Tests;

use App\Mail\Contracts\EmailProvider;
use App\Mail\Mailable;
use App\Mail\Mailer;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Psr\Log\LoggerInterface;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function createMailable()
    {
        $mailable = new Mailable();
        $mailable->setName('test');
        $mailable->setSubject('test');
        $mailable->setIsHtml(false);
        $mailable->setEmail('test');
        $mailable->setBody('test');

        return $mailable;
    }

    protected function createMockProvider($return, $error = '')
    {
        $provider = $this->getMockBuilder(EmailProvider::class)->getMock();
        $provider->expects($this->any())->method('send')->will(self::returnValue($return));
        $provider->expects($this->any())->method('error')->will(self::returnValue($error));
        return $provider;
    }

    public function createMailer()
    {
        $logger = $this->createMock(LoggerInterface::class);
        return new Mailer($logger);
    }
}
