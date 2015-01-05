<?php

namespace wataridori\ChatworkSDK\Exception;


class NoChatworkRoomException extends \Exception
{
    public function getName()
    {
        return 'Chatwork Room has not been set.';
    }
}