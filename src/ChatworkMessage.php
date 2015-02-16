<?php

namespace wataridori\ChatworkSDK;

use wataridori\ChatworkSDK\Helper\Text;

class ChatworkMessage extends ChatworkBase
{
    public $messageId = '';
    /**
     * @var ChatworkUser|null
     */
    public $account = null;
    public $body = '';
    public $sendTime = '';
    public $updateTime = '';

    public $chatworkApi;

    public function __construct($message)
    {
        if (is_array($message)) {
            foreach ($message as $key => $value) {
                $property = Text::snakeToCamel($key);
                if (property_exists($this, $property)) {
                    if ($key === 'account') {
                        $this->$property = new ChatworkUser($value);
                    } else {
                        $this->$property = $value;
                    }
                }
            }
        }

        $this->chatworkApi = new ChatworkApi();
    }

    public function toArray()
    {
        return [
            'message_id' => $this->messageId,
            'account' => $this->account->toArray(),
            'body' => $this->body,
            'send_time' => $this->sendTime,
            'update_time' => $this->updateTime,
        ];
    }
}