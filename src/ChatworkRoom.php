<?php

namespace wataridori\ChatworkSDK;

use wataridori\ChatworkSDK\Helper\Text;

class ChatworkRoom extends ChatworkBase
{
    protected $roomId = '';
    protected $name = '';
    protected $type = '';
    protected $role = '';
    protected $sticky = '';
    protected $unreadNum = '';
    protected $mentionNum = '';
    protected $mytaskNum = '';
    protected $messageNum = '';
    protected $fileNum = '';
    protected $taskNum = '';
    protected $iconPath = '';
    protected $description = '';

    public function __construct($room)
    {

        $this->init($room);

        parent::__construct($this->roomId);
        $this->chatworkApi = new ChatworkApi();
    }

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

    public function get()
    {
        $room = $this->chatworkApi->getRoomById($this->roomId);
        $this->init($room);
        return $room;
    }

    public function updateInfo($params = [])
    {
        return $this->chatworkApi->updateRoomInfo($this->roomId, $params);
    }

    public function getMembers()
    {
        $members = [];
        $results = $this->chatworkApi->getRoomMembersById($this->roomId);
        foreach ($results as $result) {
            $members[] = new ChatworkUser($result);
        }
        return $members;
    }

    public function updateMembers($members_admin_ids = [], $params = [])
    {
        return $this->chatworkApi->updateRoomMembers($this->roomId, $members_admin_ids, $params);
    }

    public function getMessages($force = false)
    {
        return $this->chatworkApi->getRoomMessages($this->roomId, $force);
    }
}