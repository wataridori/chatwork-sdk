<?php

namespace wataridori\ChatworkSDK;


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

            }
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