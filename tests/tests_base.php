<?php

use wataridori\ChatworkSDK\ChatworkBase;

class ChatworkBaseTestCase extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $chatworkBase = new ChatworkBase('random_string');
        $this->assertEquals(get_class($chatworkBase), 'wataridori\ChatworkSDK\ChatworkBase');
    }
}