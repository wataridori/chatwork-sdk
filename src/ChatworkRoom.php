<?php

namespace wataridori\ChatworkSDK;

use wataridori\ChatworkSDK\Exception\ChatworkSDKException;

class ChatworkRoom extends ChatworkBase
{
    public $room_id = '';
    public $name = '';
    public $type = '';
    public $role = '';
    public $sticky = '';
    public $unread_num = '';
    public $mention_num = '';
    public $mytask_num = '';
    public $message_num = '';
    public $file_num = '';
    public $task_num = '';
    public $icon_path = '';
    public $description = '';

    protected $listMembers = [];

    /**
     * Constructor.
     *
     * @param int|array $room
     */
    public function __construct($room)
    {
        $this->init($room);

        parent::__construct($this->room_id);
        $this->chatworkApi = new ChatworkApi();
    }

    /**
     * @param int|array $room
     */
    public function init($room)
    {
        if (is_array($room)) {
            foreach ($room as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        } elseif (is_numeric($room)) {
            $this->room_id = $room;
        }
    }

    /**
     * @return array Room Information
     */
    public function toArray()
    {
        return [
            'room_id' => $this->room_id,
            'name' => $this->name,
            'type' => $this->type,
            'role' => $this->role,
            'sticky' => $this->sticky,
            'unread_num' => $this->unread_num,
            'mention_num' => $this->mention_num,
            'mytask_num' => $this->mytask_num,
            'message_num' => $this->message_num,
            'file_num' => $this->file_num,
            'task_num' => $this->task_num,
            'icon_path' => $this->icon_path,
            'description' => $this->description,
        ];
    }

    /**
     * Get Room Information.
     *
     * @return array
     */
    public function get()
    {
        $room = $this->chatworkApi->getRoomById($this->room_id);
        $this->init($room);
        return $room;
    }

    /**
     * Update Room Information.
     *
     * @param array $params
     *
     * @return mixed|void
     */
    public function updateInfo($params = [])
    {
        return $this->chatworkApi->updateRoomInfo($this->room_id, $params);
    }

    /**
     * Get Members list of room.
     *
     * @return array
     */
    public function getMembers()
    {
        $members = [];
        $results = $this->chatworkApi->getRoomMembersById($this->room_id);
        foreach ($results as $result) {
            $members[] = new ChatworkUser($result);
        }

        $this->listMembers = $members;

        return $members;
    }

    /**
     * Update members list of room.
     *
     * @param array $members_admin_ids
     * @param array $params
     *
     * @return mixed|void
     */
    public function updateMembers($members_admin_ids = [], $params = [])
    {
        return $this->chatworkApi->updateRoomMembers($this->room_id, $members_admin_ids, $params);
    }

    /**
     * Get Messages of Room.
     *
     * @param bool $force
     *
     * @return array
     */
    public function getMessages($force = false)
    {
        $messages = [];
        $results = $this->chatworkApi->getRoomMessages($this->room_id, $force);
        if ($results) {
            foreach ($results as $result) {
                $messages[] = new ChatworkMessage($result);
            }
        }

        return $messages;
    }

    /**
     * Send Message.
     *
     * @param null $newMessage
     */
    public function sendMessage($newMessage = null)
    {
        $message = $newMessage ? $newMessage : $this->message;
        return $this->chatworkApi->createRoomMessage($this->room_id, $message);
    }

    /**
     * Send Message to list of members.
     *
     * @param ChatworkUser[] $members
     * @param string $sendMessage
     * @param bool $withName
     * @param bool $newLine
     * @param bool $usePicon
     *
     * @throws ChatworkSDKException
     */
    public function sendMessageToList($members, $sendMessage, $withName = true, $newLine = true, $usePicon = false)
    {
        $this->resetMessage();
        foreach ($members as $member) {
            if (!($member instanceof wataridori\ChatworkSDK\ChatworkUser)) {
                $this->appendTo($member, $withName, $newLine, $usePicon);
            } else {
                throw new ChatworkSDKException('Invalid Members list');
            }
        }
        $this->appendMessage($sendMessage);
        return $this->sendMessage();
    }

    /**
     * Send Message To All Members in Room.
     *
     * @param null $sendMessage
     * @param bool $mention
     */
    public function sendMessageToAll($sendMessage, $mention = true)
    {
        $message = $this->buildToAll($sendMessage, $mention);
        return $this->sendMessage($message);
    }

    /**
     * Build a Reply Message.
     *
     * @param ChatworkMessage $chatworkMessage
     * @param bool $newLine
     *
     * @return string
     */
    public function buildReplyInRoom($chatworkMessage, $newLine = true)
    {
        return $this->buildReply($this->room_id, $chatworkMessage, $newLine);
    }

    /**
     * Build a Reply Message and append it to current Message.
     *
     * @param ChatworkMessage $chatworkMessage
     * @param bool $newLine
     *
     * @throws \Exception
     *
     * @return string $message
     */
    public function appendReplyInRoom($chatworkMessage, $newLine = true)
    {
        return $this->appendReply($this->room_id, $chatworkMessage, $newLine);
    }

    /**
     * Reply list messages in room.
     *
     * @param ChatworkMessage|ChatworkMessage[] $chatworkMessages
     * @param string $msg
     * @param bool $newLine
     * @param bool $resetMessage
     */
    public function reply($chatworkMessages, $msg, $newLine = true, $resetMessage = true)
    {
        if ($resetMessage) {
            $this->resetMessage();
        }
        if ($chatworkMessages instanceof ChatworkMessage) {
            $this->appendReplyInRoom($chatworkMessages, $newLine);
        } else {
            foreach ($chatworkMessages as $chatworkMessage) {
                $this->appendReplyInRoom($chatworkMessage, $newLine);
            }
        }
        $this->appendMessage($msg);
        return $this->sendMessage();
    }
}
