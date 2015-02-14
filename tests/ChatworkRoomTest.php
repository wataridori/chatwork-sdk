<?php

use wataridori\ChatworkSDK\ChatworkSDK;
use wataridori\ChatworkSDK\ChatworkApi;
use wataridori\ChatworkSDK\ChatworkRoom;

class ChatworkRoomTest extends ChatworkTestBase
{
    protected $apiKey;
    protected $roomId;

    protected function prepareConfig()
    {
        $data = $this->loadFixture('config');
        $this->apiKey = !empty($data['apiKey']) ? $data['apiKey'] : null;
        $this->roomId = !empty($data['roomId']) ? $data['roomId'] : null;
    }

    public function testGetRoom()
    {
        $this->prepareConfig();
        if ($this->apiKey) {
            ChatworkSDK::setApiKey($this->apiKey);
            $room = new ChatworkRoom($this->roomId);
            $room->get();
            return;
        }

        $this->assertTrue(true);
    }
}