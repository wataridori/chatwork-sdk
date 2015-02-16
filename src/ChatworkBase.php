<?php

namespace wataridori\ChatworkSDK;

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
     * @var ChatworkApi $chatworkApi
     */
    protected $chatworkApi;

    /**
     * @param string|null $roomId
     */
    public function __construct($roomId = null)
    {
        $this->setApiKey(ChatworkSDK::getApiKey());
        $this->setRoomId($roomId);
        $this->chatworkApi = new ChatworkApi();
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
     * Reset message to empty string
     */
    public function resetMessage()
    {
        $this->setMessage('');
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
     * @param string $appendText
     * @return string $message
     */
    public function appendMessage($appendText)
    {
        $this->message .= $appendText;
        return $this->message;
    }

    /**
     * Build a To Message
     * @param ChatworkUser $chatworkUser
     * @param bool $newLine
     * @param bool $isPicon
     * @return string
     */
    public function buildTo($chatworkUser, $newLine = true, $isPicon = false)
    {
        $key = $isPicon ? 'picon' : 'To';
        return "[$key:$chatworkUser->accountId] $chatworkUser->name" . ($newLine ? "\n" : '');
    }

    /**
     * Build a To Message and append it to current Message
     * @param ChatworkUser $chatworkUser
     * @param bool $newLine
     * @param bool $isPicon
     * @return string $message
     */
    public function appendTo($chatworkUser, $newLine = true, $isPicon = false)
    {
        $text = $this->buildTo($chatworkUser, $newLine, $isPicon);
        return $this->appendMessage($text);
    }

    /**
     * Build a Reply Message
     *
     * @param string $roomId
     * @param ChatworkMessage $chatworkMessage
     * @param bool $newLine
     * @return string
     * @throws NoChatworkRoomException
     */
    public function buildReply($roomId, $chatworkMessage, $newLine = true)
    {
        if (!$roomId) {
            if (!$this->roomId) {
                throw new NoChatworkRoomException;
            } else {
                $roomId = $this->roomId;
            }
        }

        return "[rp aid={$chatworkMessage->account->accountId} to={$roomId}-{$chatworkMessage->messageId}] {$chatworkMessage->account->name}" . ($newLine ? "\n" : '');
    }

    /**
     * Build a Reply Message and append it to current Message
     *
     * @param string $roomId
     * @param ChatworkMessage $chatworkMessage
     * @param bool $newLine
     * @return string $message
     * @throws \Exception
     */
    public function appendReply($roomId, $chatworkMessage, $newLine = true)
    {
        $text = $this->buildReply($roomId, $chatworkMessage, $newLine);
        return $this->appendMessage($text);
    }

    /**
     * Build quote message
     *
     * @param ChatworkMessage $chatworkMessage
     * @param bool $time
     * @return string
     */
    public function buildQuote($chatworkMessage, $time = true)
    {
        $timeText = $time ? "time={$chatworkMessage->sendTime}" : '';
        return "[qt][qtmeta aid={$chatworkMessage->account->accountId} {$timeText}]{$chatworkMessage->body}[/qt]";
    }

    /**
     * Build quote message and apply it to current Message
     *
     * @param ChatworkMessage $chatworkMessage
     * @param bool $time
     * @return string
     */
    public function appendQuote($chatworkMessage, $time = true)
    {
        $text = $this->buildQuote($chatworkMessage, $time);
        return $this->appendMessage($text);
    }

    /**
     * Build Information tag
     * @param string $message
     * @param string $title
     * @return string
     */
    public function buildInfo($message, $title = '')
    {
        if ($title) {
            return "[info][title]$title [/title]$message [/info]";
        }
        return "[info]$message [/info]";
    }

    /**
     * Build Information tag and append it to current message
     * @param string $message
     * @param string $title
     * @return string $message
     */
    public function appendInfo($message, $title = '')
    {
        $info = $this->buildInfo($message, $title);
        return $this->appendMessage($info);
    }
}