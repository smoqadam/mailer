<?php

namespace Tests\Unit\Mail;

use App\Mail\Contracts\EmailProvider;
use App\Mail\ProviderCollection;
use Tests\TestCase;

class ProviderCollectionTest extends TestCase
{
    public function testAddStringToProviderCollection()
    {
        $this->expectException(\InvalidArgumentException::class);
        $collection = new ProviderCollection();
        $collection[] = 'test';
    }

    public function testProviderCollection()
    {
        $collection = new ProviderCollection();
        $provider = $this->mock(EmailProvider::class);
        $collection[] = $provider;
        $this->assertCount(1, $collection);
    }
}
