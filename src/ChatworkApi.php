<?php

namespace wataridori\ChatworkSDK;

class ChatworkApi
{
    /**
     * @var string apiKey
     */
    protected $apiKey;

    /**
     * @param $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
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
     * Call Chatwork API
     * @param string $endPoint
     * @param string $method
     * @param array $params
     * @return array
     */
    protected function api($endPoint, $method = ChatworkRequest::REQUEST_METHOD_GET, $params = [])
    {
        $request = new ChatworkRequest($this->apiKey);
        $request->setEndPoint($endPoint);
        $request->setMethod($method);
        $request->setParams($params);

        $response = $request->send();

        return $response;
    }
}