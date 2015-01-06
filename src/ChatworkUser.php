<?php

namespace wataridori\ChatworkSDK;

use wataridori\ChatworkSDK\Helper\Text;

class ChatworkUser extends ChatworkBase
{
    protected $accountId;
    protected $role = '';
    protected $name = '';
    protected $chatworkId = '';
    protected $organizationId = '';
    protected $organizationName = '';
    protected $department = '';
    protected $avatarImageUrl = '';

    public function __construct($account, $name = '', $avatarImageUrl = '')
    {
        if (is_array($account)) {
            foreach ($account as $key => $value) {
                $property = Text::snakeToCamel($key);
                if (property_exists($this, $property)) {
                    $this->$property = $value;
                }
            }
        } elseif (is_numeric($account)) {
            $this->accountId = $account;
            $this->name = $name;
            $this->avatarImageUrl = $avatarImageUrl;
        }
    }

    public function toArray()
    {
        return [
            'account_id' => $this->accountId,
            'role' => $this->role,
            'name' => $this->name,
            'chatwork_id' => $this->chatworkId,
            'organization_id' => $this->organizationId,
            'organization_name' => $this->organizationName,
            'department' => $this->department,
            'avatar_image_url' => $this->avatarImageUrl
        ];
    }
}