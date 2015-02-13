<?php

namespace wataridori\ChatworkSDK;

class ChatworkApi
{
    /**
     * @var string apiKey
     */
    static $apiKey = '';

    /**
     * @param $apiKey
     */
    public function __construct($apiKey)
    {
        self::$apiKey = $apiKey;
    }

    /**
     * Get user own information
     * @return array
     * @see http://developer.chatwork.com/ja/endpoint_me.html#GET-me
     */
    public function me()
    {
        return $this->api('me');
    }

    /**
     * Get user own statics information
     * @return array
     * @see http://developer.chatwork.com/ja/endpoint_my.html#GET-my-status
     */
    public function getMyStatus()
    {
        return $this->api('my/status');
    }

    /**
     * Get user own task information
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
     * @param       $name
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
            self::HTTP_METHOD_POST,
            $this->params[self::PARAM_ENDPOINT],
            '/v1/rooms',
            array(),
            $params
        );
    }

    /**
     * get specified room information
     *
     * @param string $room_id
     * @return array
     * @throws UnauthorizedException
     * @see http://developer.chatwork.com/ja/endpoint_rooms.html#GET-rooms-room_id
     */
    public function getRoomById($room_id)
    {
        return $this->api(
            self::HTTP_METHOD_GET,
            $this->params[self::PARAM_ENDPOINT],
            sprintf('/v1/rooms/%d', $room_id),
            array()
        );
    }

    /**
     * get specified room members
     *
     * @param string $room_id
     * @return array
     * @throws UnauthorizedException
     * @see http://developer.chatwork.com/ja/endpoint_rooms.html#GET-rooms-room_id-members
     */
    public function getRoomMembersById($room_id)
    {
        return $this->api(
            self::HTTP_METHOD_GET,
            $this->params[self::PARAM_ENDPOINT],
            sprintf('/v1/rooms/%d/members', $room_id),
            array()
        );
    }


    /**
     * update room meta information
     *
     * @param       $room_id
     * @param array $params
     * @return mixed|void
     * @throws UnauthorizedException
     * @see http://developer.chatwork.com/ja/endpoint_rooms.html#PUT-rooms-room_id
     */
    public function updateRoomInfo($room_id, $params = array())
    {
        return $this->api(
            self::HTTP_METHOD_PUT,
            $this->params[self::PARAM_ENDPOINT],
            sprintf('/v1/rooms/%d', $room_id),
            array(),
            $params
        );
    }

    /**
     * delete room
     *
     * @param $room_id
     * @return array
     * @throws UnauthorizedException
     * @see http://developer.chatwork.com/ja/endpoint_rooms.html#DELETE-rooms-room_id
     */
    public function deleteRoom($room_id)
    {
        return $this->api(
            self::HTTP_METHOD_DELETE,
            $this->params[self::PARAM_ENDPOINT],
            sprintf('/v1/rooms/%d', $room_id),
            array(),
            array(
                "action_type" => "delete",
            )
        );
    }

    /**
     * leave room
     *
     * @param $room_id
     * @return array
     * @throws UnauthorizedException
     * @see http://developer.chatwork.com/ja/endpoint_rooms.html#DELETE-rooms-room_id
     */
    public function leaveRoom($room_id)
    {
        return $this->api(
            self::HTTP_METHOD_DELETE,
            $this->params[self::PARAM_ENDPOINT],
            sprintf('/v1/rooms/%d', $room_id),
            array(),
            array(
                "action_type" => "leave",
            )
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

        return $response;
    }
}