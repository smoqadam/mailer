<?php

namespace Tests\Unit\Mail;

use App\Mail\Contracts\EmailProvider;
use App\Mail\Exceptions\MailerException;
use App\Mail\Mailable;
use App\Mail\Mailer;
use Tests\TestCase;

class MailerTest extends TestCase
{
    public function testSendFail()
    {
        $mailer = new Mailer();
        $provider = $this->getMockBuilder(EmailProvider::class)->getMock();
        $provider->expects($this->any())->method('send')->will(self::returnValue(false));
        $mailer->setProvider($provider);
        $this->expectException(MailerException::class);
        $mailer->send($this->createMailable());
    }

    public function testSendProviderNotSetException()
    {
        $mailer = new Mailer();
        $mailable = $this->createMailable();
        $this->expectException(\InvalidArgumentException::class);
        $mailer->send($mailable);
    }

}
