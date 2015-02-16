<?php

use wataridori\ChatworkSDK\ChatworkSDK;
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
            ChatworkSDK::setApiKey($this->apiKey);
            $api = new ChatworkApi();
            $api->me();
        }

        $this->assertTrue(true);
    }

    public function testGetMyStatus()
    {
        $this->prepareConfig();
        if ($this->apiKey) {
            ChatworkSDK::setApiKey($this->apiKey);
            $api = new ChatworkApi();
            $api->getMyStatus();
        }

        $this->assertTrue(true);
    }

    public function testGetMyTasks()
    {
        $this->prepareConfig();
        if ($this->apiKey) {
            ChatworkSDK::setApiKey($this->apiKey);
            $api = new ChatworkApi();
            $api->getMyTasks();
        }

        $this->assertTrue(true);
    }

    public function testGetContacts()
    {
        $this->prepareConfig();
        if ($this->apiKey) {
            ChatworkSDK::setApiKey($this->apiKey);
            $api = new ChatworkApi();
            $api->getContacts();
        }

        $this->assertTrue(true);
    }

    public function testGetRooms()
    {
        $this->prepareConfig();
        if ($this->apiKey) {
            ChatworkSDK::setApiKey($this->apiKey);
            $api = new ChatworkApi();
            $api->getRooms();
        }

        $this->assertTrue(true);
    }
}