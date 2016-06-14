<?php

namespace wataridori\ChatworkSDK;

class ChatworkSDK
{
    /**
     * @var string
     */
    protected static $apiKey = '';
    protected static $sslVerificationMode = true;

    public function __construct($apiKey, $sslVerificationMode = true)
    {
        self::setApiKey($apiKey);
        self::setSslVerificationMode($sslVerificationMode);
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

    /**
     * Get SSL verfication mode
     *
     * @return string
     */
    public static function getSslVerificationMode()
    {
        return self::$sslVerificationMode;
    }

    /**
     * Set SSL verfication mode
     *
     * @param $sslVerificationMode
     */
    public static function setSslVerificationMode($sslVerificationMode)
    {
        self::$sslVerificationMode = $sslVerificationMode;
    }
}
