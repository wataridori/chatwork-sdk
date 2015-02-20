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
            $this->assertEquals($room->room_id, $this->roomId);
        }

        $this->assertTrue(true);
    }

    public function testGetMembers()
    {
        $this->prepareConfig();
        if ($this->apiKey) {
            ChatworkSDK::setApiKey($this->apiKey);
            $room = new ChatworkRoom($this->roomId);
            $room->get();
            $members = $room->getMembers();
            $this->assertInternalType('array', $members);
            $checkClass = true;
            foreach ($members as $member) {
                if (!($member instanceof wataridori\ChatworkSDK\ChatworkUser)) {
                    $checkClass = false;
                }
            }
            $room->sendMessageToAll('Just a test message from ChatworkSDK for PHP. Mention without name and new line.', false, false);
            $room->sendMessageToList(array_slice($members, 0, 1), 'Just another test message from ChatworkSDK for PHP. Use Picon only', false, false, true);
            $this->assertTrue($checkClass);
        }

        $this->assertTrue(true);
    }

    public function testGetMessages()
    {
        $this->prepareConfig();
        if ($this->apiKey) {
            ChatworkSDK::setApiKey($this->apiKey);
            $room = new ChatworkRoom($this->roomId);
            $messages = $room->getMessages();
            $this->assertInternalType('array', $messages);
            $checkClass = true;
            $lastMessage = null;
            foreach ($messages as $message) {
                if (!($message instanceof wataridori\ChatworkSDK\ChatworkMessage)) {
                    $checkClass = false;
                }
                $lastMessage = $message;
            }

            $this->assertTrue($checkClass);
            if ($lastMessage) {
                $room->resetMessage();
                $room->appendReplyInRoom($lastMessage);
                $room->appendQuote($lastMessage);
                $room->appendInfo('Test Quote, Reply, Info text', 'Test from Chatwork-SDK');
                $room->sendMessage();
            }
        }

        $this->assertTrue(true);
    }
}