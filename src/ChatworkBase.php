<?php

namespace wataridori\ChatworkSDK;

class ChatworkBase
{
    protected $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }
}