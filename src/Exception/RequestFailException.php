<?php

namespace wataridori\ChatworkSDK\Exception;


class RequestFailException extends \Exception
{
    public function getName()
    {
        return 'Request fail';
    }
}