<?php

namespace Tests\Unit\Mail;
use App\Mail\Collection;
use Tests\TestCase;

class CollectionTest extends TestCase
{
    public function testAddFloatToIntCollection()
    {
        $this->expectException(\InvalidArgumentException::class);
        $collection = new Collection('int');
        $collection[] = 1;
        $collection[] = 2;
        $collection[] = 2.2;
    }

    public function testAddStringToIntCollection()
    {
        $this->expectException(\InvalidArgumentException::class);
        $collection = new Collection('int');
        $collection[] = 1;
        $collection[] = 2;
        $collection[] = ['test'];
    }

    /// other tests
}
