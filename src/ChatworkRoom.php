<?php

namespace wataridori\ChatworkSDK;

use wataridori\ChatworkSDK\Exception\ChatworkSDKException;
use wataridori\ChatworkSDK\Helper\Text;

class ChatworkRoom extends ChatworkBase
{
    public $roomId = '';
    public $name = '';
    public $type = '';
    public $role = '';
    public $sticky = '';
    public $unreadNum = '';
    public $mentionNum = '';
    public $mytaskNum = '';
    public $messageNum = '';
    public $fileNum = '';
    public $taskNum = '';
    public $iconPath = '';
    public $description = '';

    protected $listMembers = [];
    /**
     * Constructor
     *
     * @param int|array $room
     */
    public function __construct($room)
    {

        $this->init($room);

        parent::__construct($this->roomId);
        $this->chatworkApi = new ChatworkApi();
    }

    /**
     * @param int|array $room
     */
    public function init($room)
    {
        if (is_array($room)) {
            foreach ($room as $key => $value) {
                $property = Text::snakeToCamel($key);
                if (property_exists($this, $property)) {
                    $this->$property = $value;
                }
            }
        } elseif (is_numeric($room)) {
            $this->roomId = $room;
        }
    }

    /**
     * @return array Room Information
     */
    public function toArray()
    {
        return [
            'roomId' => $this->roomId,
            'name' => $this->name,
            'type' => $this->type,
            'role' => $this->role,
            'sticky' => $this->sticky,
            'unread_num' => $this->unreadNum,
            'mention_num' => $this->mentionNum,
            'mytask_num' => $this->mytaskNum,
            'message_num' => $this->messageNum,
            'file_num' => $this->fileNum,
            'task_num' => $this->taskNum,
            'icon_path' => $this->iconPath,
            'description' => $this->description,
        ];
    }

    /**
     * Get Room Information
     *
     * @return array
     */
    public function get()
    {
        $room = $this->chatworkApi->getRoomById($this->roomId);
        $this->init($room);
        return $room;
    }

    /**
     * Update Room Information
     *
     * @param array $params
     * @return mixed|void
     */
    public function updateInfo($params = [])
    {
        return $this->chatworkApi->updateRoomInfo($this->roomId, $params);
    }

    /**
     * Get Members list of room
     *
     * @return array
     */
    public function getMembers()
    {
        $members = [];
        $results = $this->chatworkApi->getRoomMembersById($this->roomId);
        foreach ($results as $result) {
            $members[] = new ChatworkUser($result);
        }

        $this->listMembers = $members;

        return $members;
    }

    /**
     * Update members list of room
     * @param array $members_admin_ids
     * @param array $params
     * @return mixed|void
     */
    public function updateMembers($members_admin_ids = [], $params = [])
    {
        return $this->chatworkApi->updateRoomMembers($this->roomId, $members_admin_ids, $params);
    }

    /**
     * Get Messages of Room
     *
     * @param bool $force
     * @return array
     */
    public function getMessages($force = false)
    {
        return $this->chatworkApi->getRoomMessages($this->roomId, $force);
    }

    /**
     * Send Message
     *
     * @param null $newMessage
     */
    public function sendMessage($newMessage = null)
    {
        $message = $newMessage ? $newMessage : $this->message;
        $this->chatworkApi->createRoomMessage($this->roomId, $message);
    }

    /**
     * Send Message to list of members
     *
     * @param ChatworkUser[] $members
     * @param string $sendMessage
     * @throws ChatworkSDKException
     */
    public function sendMessageToList($members, $sendMessage)
    {
        $this->resetMessage();
        foreach ($members as $member) {
            if (!($member instanceof wataridori\ChatworkSDK\ChatworkUser)) {
                $this->appendTo($member);
            } else {
                throw new ChatworkSDKException('Invalid Members list');
            }
        }
        $this->appendMessage($sendMessage);
        $this->sendMessage();
    }

    /**
     * Send Message To All Members in Room
     *
     * @param null $sendMessage
     */
    public function sendMessageToAll($sendMessage)
    {
        if (!$this->listMembers) {
            $this->getMembers();
        }

        if ($this->listMembers) {
            $this->sendMessageToList($this->listMembers, $sendMessage);
        }
    }
}