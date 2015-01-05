<?php

use wataridori\ChatworkSDK\ChatworkBase;
use wataridori\ChatworkSDK\ChatworkSDK;

class ChatworkSDKTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $chatworkSDK = new ChatworkSDK('random_string');
        $this->assertEquals(get_class($chatworkSDK), 'wataridori\ChatworkSDK\ChatworkSDK');
    }
}

