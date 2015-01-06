<?php

use wataridori\ChatworkSDK\ChatworkApi;

class ChatworkApiTest extends ChatworkTestBase
{
    protected $apiKey;
    protected $roomId;

    protected function prepareConfig()
    {
        $data = $this->loadFixture('config');
        $this->apiKey = !empty($data['apiKey']) ? $data['apiKey'] : null;
        $this->roomId = !empty($data['roomId']) ? $data['roomId'] : null;
    }

    public function testMe()
    {
        $this->prepareConfig();
        if ($this->apiKey) {
            $api = new ChatworkApi($this->apiKey);
            $response = $api->me();
            $this->assertArrayHasKey('http_code', $response);
            $this->assertArrayHasKey('response', $response);
            return;
        }

        $this->assertTrue(true);
    }
}