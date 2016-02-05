<?php

namespace wataridori\ChatworkSDK;

class ChatworkSDK
{
    /**
     * @var string
     */
    protected static $apiKey = '';

    public function __construct($apiKey)
    {
        self::setApiKey($apiKey);
    }

    /**
     * Get Chatwork API Key.
     *
     * @return string
     */
    public static function getApiKey()
    {
        return self::$apiKey;
    }

    /**
     * Set Chatwork API Key.
     *
     * @param $apiKey
     */
    public static function setApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }
}
