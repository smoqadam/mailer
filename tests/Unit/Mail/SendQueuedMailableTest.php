<?php

namespace Tests\Unit\Mail;

use App\Mail\Mailer;
use App\Mail\SendQueuedMailable;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class SendQueuedMailableTest extends TestCase
{
    public function testAddProvider()
    {
        $queuedMailable = new SendQueuedMailable(new Mailer());
        $provider = $this->createMockProvider(true);
        $queuedMailable->addProvider($provider);
        $this->assertCount(1, $queuedMailable->getProviders());
    }

    public function testNullProviders()
    {
        $this->expectException(\InvalidArgumentException::class);
        $queuedMailable = new SendQueuedMailable(new Mailer());
        $queuedMailable->send($this->createMailable());
    }

    public function testSendShouldFail()
    {
        Log::shouldReceive('error')->once()->with('error');

        $queuedMailable = new SendQueuedMailable(new Mailer());
        $provider1 = $this->createMockProvider(false, 'error');
        $result = $queuedMailable
            ->addProvider($provider1)
            ->send($this->createMailable());

        $this->assertFalse($result);
    }

    public function testSendShouldRun()
    {
        $queuedMailable = new SendQueuedMailable(new Mailer());
        $provider1 = $this->createMockProvider(true);
        $result = $queuedMailable
            ->addProvider($provider1)
            ->send($this->createMailable());

        $this->assertTrue($result);
    }

    public function testSendSecondProviderShouldRun()
    {
        /// error for the first provider
        Log::shouldReceive('error')->once()->with('error');
        /// info for the second provider
        Log::shouldReceive('info')->once()->with('success');

        $queuedMailable = new SendQueuedMailable(new Mailer());
        $provider1 = $this->createMockProvider(false, 'error');
        $provider2 = $this->createMockProvider(true);
        $result = $queuedMailable
            ->addProvider($provider1)
            ->addProvider($provider2)
            ->send($this->createMailable());

        $this->assertTrue($result);
    }

    public function testSendSecondProviderShouldNotRun()
    {
        /// expecting one info log for the first provider
        Log::shouldReceive('info')->once()->with('success');

        $queuedMailable = new SendQueuedMailable(new Mailer());
        $provider1 = $this->createMockProvider(true);
        $provider2 = $this->createMockProvider(true);
        $result = $queuedMailable
            ->addProvider($provider1)
            ->addProvider($provider2)
            ->send($this->createMailable());

        $this->assertTrue($result);
    }
}
