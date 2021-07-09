<?php

namespace Tests;

use App\Mail\Mailable;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

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
}
