<?php

namespace Tests\Unit\Mail;

use App\Jobs\MailSend;
use App\Mail\Contracts\EmailProvider;
use App\Mail\Exceptions\MailerException;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class MailerTest extends TestCase
{
    public function testSendFail()
    {
        $mailer = $this->createMailer();
        $provider = $this->getMockBuilder(EmailProvider::class)->getMock();
        $provider->expects($this->any())->method('send')->will(self::returnValue(false));
        $mailer->setProvider($provider);
        $this->expectException(MailerException::class);
        $mailer->send($this->createMailable());
    }

    public function testSendProviderNotSetException()
    {
        $mailer = $this->createMailer();
        $mailable = $this->createMailable();
        $this->expectException(\InvalidArgumentException::class);
        $mailer->send($mailable);
    }

    public function testQueue()
    {
        Queue::fake();
        $mailer = $this->createMailer();
        $mailer->queue($this->createMailable());
        Queue::assertPushed(MailSend::class);
    }

    public function testQueueTwice()
    {
        Queue::fake();
        $mailer = $this->createMailer();
        $mailer->queue($this->createMailable());
        $mailer->queue($this->createMailable());
        Queue::assertPushed(MailSend::class, 2);
    }
}
