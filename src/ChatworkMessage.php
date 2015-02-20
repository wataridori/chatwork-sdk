<?php

namespace wataridori\ChatworkSDK;

class ChatworkMessage extends ChatworkBase
{
    public $message_id = '';
    /**
     * @var ChatworkUser|null
     */
    public $account = null;
    public $body = '';
    public $send_time = '';
    public $update_time = '';

    public $chatworkApi;

    public function __construct($message)
    {
        if (is_array($message)) {
            foreach ($message as $key => $value) {
                if (property_exists($this, $key)) {
                    if ($key === 'account') {
                        $this->$key = new ChatworkUser($value);
                    } else {
                        $this->$key = $value;
                    }
                }
            }
        }

        $this->chatworkApi = new ChatworkApi();
    }

    public function toArray()
    {
        return [
            'message_id' => $this->message_id,
            'account' => $this->account->toArray(),
            'body' => $this->body,
            'send_time' => $this->send_time,
            'update_time' => $this->update_time,
        ];
    }
}