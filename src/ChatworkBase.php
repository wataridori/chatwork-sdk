<?php

namespace wataridori\ChatworkSDK;

use wataridori\ChatworkSDK\Exception\NoChatworkApiKeyException;
use wataridori\ChatworkSDK\Exception\NoChatworkRoomException;

class ChatworkBase
{
    /**
     * Chatwork Api Key
     * @var $apiKey
     */
    protected $apiKey;

    /**
     * Chatwork Room Id
     * @var $roomId
     */
    protected $roomId;

    /**
     * @var $message
     */
    protected $message;

    /**
     * @param string $apiKey
     * @param string|null $roomId
     */
    public function __construct($apiKey = '', $roomId = null)
    {
        $this->setApiKey($apiKey);
        $this->setRoomId($roomId);
    }

    /**
     * Set api key
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Get ApiKey
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Set RoomId
     * @param string $roomId
     */
    public function setRoomId($roomId)
    {
        $this->roomId = $roomId;
    }

    /**
     * @return string|null
     */
    public function getRoomId()
    {
        return $this->roomId;
    }

    /**
     * Set message
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Append inputted text to current message
     * @param $appendText
     */
    public function appendMessage($appendText)
    {
        $this->message .= $appendText;
    }

    /**
     * Build a To Message
     * @param string $userId
     * @param string $userName
     * @param bool $newLine
     * @param bool $isPicon
     * @return string
     */
    public function buildTo($userId, $userName = '', $newLine = true, $isPicon = false)
    {
        $key = $isPicon ? 'picon' : 'To';
        return "[$key:$userId] $userName" . ($newLine ? "\n" : '');
    }

    /**
     * Build a To Message and append it to current Message
     * @param string $userId
     * @param string $userName
     * @param bool $newLine
     * @param bool $isPicon
     */
    public function appendTo($userId, $userName = '', $newLine = true, $isPicon = false)
    {
        $text = $this->buildTo($userId, $userName, $newLine, $isPicon);
        $this->appendMessage($text);
    }

    /**
     * Build a Reply Message
     * @param string $userId
     * @param string $messageId
     * @param string $roomId
     * @param string $userName
     * @param bool $newLine
     * @return string
     * @throws NoChatworkRoomException
     */
    public function buildReply($userId, $messageId, $roomId = '', $userName = '', $newLine = true)
    {
        if (!$roomId) {
            if (!$this->roomId) {
                throw new NoChatworkRoomException;
            } else {
                $roomId = $this->roomId;
            }
        }

        return "[rp aid={$userId} to={$roomId}-{$messageId}] $userName" . ($newLine ? "\n" : '');
    }

    /**
     * Build a Reply Message and append it to current Message
     * @param string $userId
     * @param string $messageId
     * @param string $roomId
     * @param string $userName
     * @param bool $newLine
     * @throws \Exception
     */
    public function appendReply($userId, $messageId, $roomId = '', $userName = '', $newLine = true)
    {
        $text = $this->buildReply($userId, $messageId, $roomId, $userName, $newLine);
        $this->appendMessage($text);
    }
}