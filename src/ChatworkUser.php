<?php

namespace wataridori\ChatworkSDK;

use wataridori\ChatworkSDK\Helper\Text;

class ChatworkUser extends ChatworkBase
{
    public $accountId;
    public $role = '';
    public $name = '';
    public $chatworkId = '';
    public $organizationId = '';
    public $organizationName = '';
    public $department = '';
    public $avatarImageUrl = '';

    protected $chatworkApi;

    /**
     * @param array|string $account
     * @param string $name
     * @param string $avatarImageUrl
     */
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

        $this->chatworkApi = new ChatworkApi();
    }

    /**
     * User information in array
     * @return array
     */
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