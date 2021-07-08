<?php

namespace Tests\Unit;

use App\Mail\EmailProviders\Sendgrid;
use App\Mail\Mailable;
use App\Mail\Mailer;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function testExample()
    {
        $mailable = new Mailable();
        $mailable->setEmail('saeed.moqadam@gmail.com');
        $mailable->setName('Saeed');
        $mailable->setBody('Hello');
        $mailable->setSubject('Email subject');
        $mail = new Mailer(new Sendgrid());
        $mail->send($mailable);
    }
}
