<?php

namespace wataridori\ChatworkSDK;

class ChatworkApi
{
    /**
     * @var string apiKey
     */
    static $apiKey = '';

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$apiKey = ChatworkSDK::getApiKey();
    }

    /**
     * Get user own information
     *
     * @return array
     * @see http://developer.chatwork.com/ja/endpoint_me.html#GET-me
     */
    public function me()
    {
        return $this->api('me');
    }

    /**
     * Get user own statics information
     *
     * @return array
     * @see http://developer.chatwork.com/ja/endpoint_my.html#GET-my-status
     */
    public function getMyStatus()
    {
        return $this->api('my/status');
    }

    /**
     * Get user own task information
     *
     * @param array $params
     * @return array
     * @see http://developer.chatwork.com/ja/endpoint_my.html#GET-my-tasks
     */
    public function getMyTasks($params = [])
    {
        return $this->api('my/tasks', ChatworkRequest::REQUEST_METHOD_GET, $params);
    }

    /**
     * Get user contacts list
     * @return array
     * @see http://developer.chatwork.com/ja/endpoint_contacts.html#GET-contacts
     */
    public function getContacts()
    {
        return $this->api('contacts');
    }

    /**
     * Get user rooms list
     *
     * @return array
     * @see http://developer.chatwork.com/ja/endpoint_rooms.html#GET-rooms
     */
    public function getRooms()
    {
        return $this->api('rooms');
    }

    /**
     * Create new room
     *
     * @param string $name
     * @param array $members_admin_ids
     * @param array $params
     * @return array
     * @see http://developer.chatwork.com/ja/endpoint_rooms.html#POST-rooms
     */
    public function createRoom($name, $members_admin_ids = [], $params = [])
    {
        $params['members_admin_ids'] = implode(',', $members_admin_ids);
        $params['name'] = implode(',', $name);

        $params['members_admin_ids'] = join(",", $params['members_admin_ids']);
        if (isset($params['members_members_id'])) {
            $params['members_members_id'] = join(",", $params['members_members_id']);
        }
        if (isset($params['members_readonly_ids'])) {
            $params['members_readonly_ids'] = join(",", $params['members_readonly_ids']);
        }

        return $this->api(
            'rooms',
            ChatworkRequest::REQUEST_METHOD_POST,
            $params
        );
    }

    /**
     * Get room information
     *
     * @param int $room_id
     * @return array
     * @see http://developer.chatwork.com/ja/endpoint_rooms.html#GET-rooms-room_id
     */
    public function getRoomById($room_id)
    {
        return $this->api(
            sprintf('rooms/%d', $room_id)
        );
    }

    /**
     * Update room information
     *
     * @param int $room_id
     * @param array $params
     * @return mixed|void
     * @see http://developer.chatwork.com/ja/endpoint_rooms.html#PUT-rooms-room_id
     */
    public function updateRoomInfo($room_id, $params = [])
    {
        return $this->api(
            sprintf('rooms/%d', $room_id),
            ChatworkRequest::REQUEST_METHOD_PUT,
            $params
        );
    }

    /**
     * Delete room
     *
     * @param int $room_id
     * @return array
     * @see http://developer.chatwork.com/ja/endpoint_rooms.html#DELETE-rooms-room_id
     */
    public function deleteRoom($room_id)
    {
        return $this->api(
            sprintf('rooms/%d', $room_id),
            ChatworkRequest::REQUEST_METHOD_DELETE,
            ['action_type' => 'delete']
        );
    }

    /**
     * Leave room
     *
     * @param int $room_id
     * @return array
     * @see http://developer.chatwork.com/ja/endpoint_rooms.html#DELETE-rooms-room_id
     */
    public function leaveRoom($room_id)
    {
        return $this->api(
            sprintf('rooms/%d', $room_id),
            ChatworkRequest::REQUEST_METHOD_DELETE,
            ['action_type' => 'leave']
        );
    }

    /**
     * Get all members of a room
     *
     * @param int $room_id
     * @return array
     * @see http://developer.chatwork.com/ja/endpoint_rooms.html#GET-rooms-room_id-members
     */
    public function getRoomMembersById($room_id)
    {
        return $this->api(
            sprintf('rooms/%d/members', $room_id)
        );
    }

    /**
     * Update current room members
     *
     * @param int $room_id
     * @param array $members_admin_ids
     * @param array $params
     * @return mixed|void
     * @see http://developer.chatwork.com/ja/endpoint_rooms.html#PUT-rooms-room_id-members
     */
    public function updateRoomMembers($room_id, $members_admin_ids = [], $params = [])
    {
        $params = array_merge([
            'members_admin_ids' => $members_admin_ids,
        ], $params);

        if (isset($params['members_member_ids'])) {
            $params['members_admin_ids'] = join(',', $params['members_admin_ids']);
        }
        if (isset($params['members_member_ids'])) {
            $params['members_member_ids'] = join(',', $params['members_member_ids']);
        }
        if (isset($params['members_readonly_ids'])) {
            $params['members_readonly_ids'] = join(',', $params['members_readonly_ids']);
        }

        return $this->api(
            sprintf('rooms/%d', $room_id),
            ChatworkRequest::REQUEST_METHOD_PUT,
            $params
        );
    }

    /**
     * Get messages of a room
     *
     * @param int $room_id
     * @param bool $force
     * @return array
     * @see http://developer.chatwork.com/ja/endpoint_rooms.html#GET-rooms-room_id-messages
     */
    public function getRoomMessages($room_id, $force = false)
    {
        return $this->api(
            sprintf('rooms/%d/messages', $room_id),
            ChatworkRequest::REQUEST_METHOD_GET,
            ['force' => $force ? 1 : 0]
        );
    }

    /**
     * Create a message
     *
     * @param int $room_id
     * @param string $body
     * @return array
     * @see http://developer.chatwork.com/ja/endpoint_rooms.html#GET-rooms-room_id-messages
     */
    public function createRoomMessage($room_id, $body)
    {
        return $this->api(
            sprintf('rooms/%d/messages', $room_id),
            ChatworkRequest::REQUEST_METHOD_POST,
            ['body' => $body]
        );
    }

    /**
     * Get a message
     *
     * @param int $room_id
     * @param int $message_id
     * @return array
     * @see http://developer.chatwork.com/ja/endpoint_rooms.html#GET-rooms-room_id-messages-message_id
     */
    public function getRoomMessageByMessageId($room_id, $message_id)
    {
        return $this->api(
            sprintf('rooms/%d/messages/%d', $room_id, $message_id)
        );
    }

    /**
     * Get tasks of a room
     *
     * @param int $room_id
     * @param array $params
     * @return mixed|void
     * @see http://developer.chatwork.com/ja/endpoint_rooms.html#GET-rooms-room_id-tasks
     */
    public function getRoomTasks($room_id, $params = [])
    {
        return $this->api(
            sprintf('rooms/%d/tasks', $room_id),
            ChatworkRequest::REQUEST_METHOD_GET,
            $params
        );
    }

    /**
     * Get a task of a room
     *
     * @param int $room_id
     * @param int $task_id
     * @return mixed|void
     * @see http://developer.chatwork.com/ja/endpoint_rooms.html#GET-rooms-room_id-tasks-task_id
     */
    public function getRoomTaskById($room_id, $task_id)
    {
        return $this->api(
            sprintf('rooms/%d/tasks/%d', $room_id, $task_id)
        );
    }

    /**
     * Add new task
     *
     * @param int $room_id
     * @param array $to_ids
     * @param string $body
     * @param null|string $limit
     * @return mixed|void
     * @see http://developer.chatwork.com/ja/endpoint_rooms.html#POST-rooms-room_id-tasks
     */
    public function addTask($room_id, $to_ids = [], $body, $limit = null)
    {
        $params = [
            'to_ids' => join(',', $to_ids),
            'body' => $body,
            'limit' => $limit,
        ];

        return $this->api(
            sprintf('rooms/%d/tasks', $room_id),
            ChatworkRequest::REQUEST_METHOD_POST,
            $params
        );
    }

    /**
     * Get files of a room
     *
     * @param int $room_id
     * @param array $params
     * @return array
     * @see http://developer.chatwork.com/ja/endpoint_rooms.html#GET-rooms-room_id-files
     */
    public function getRoomFiles($room_id, $params = [])
    {
        return $this->api(
            sprintf('rooms/%d/files', $room_id),
            ChatworkRequest::REQUEST_METHOD_GET,
            $params
        );
    }

    /**
     * Get file of a room
     *
     * @param int $room_id
     * @param int $file_id
     * @param bool $create_download_url
     * @return mixed|void
     * @see http://developer.chatwork.com/ja/endpoint_rooms.html#GET-rooms-room_id-files-file_id
     */
    public function getRoomFileById($room_id, $file_id, $create_download_url = false)
    {
        return $this->api(
            sprintf('rooms/%d/files/%d', $room_id, $file_id),
            ChatworkRequest::REQUEST_METHOD_GET,
            ['create_download_url' => $create_download_url ? 1 : 0]
        );
    }

    /**
     * Call Chatwork API
     * @param string $endPoint
     * @param string $method
     * @param array $params
     * @return array
     */
    protected function api($endPoint, $method = ChatworkRequest::REQUEST_METHOD_GET, $params = [])
    {
        $request = new ChatworkRequest(self::$apiKey);
        $request->setEndPoint($endPoint);
        $request->setMethod($method);
        $request->setParams($params);

        $response = $request->send();

        return $response['response'];
    }
}