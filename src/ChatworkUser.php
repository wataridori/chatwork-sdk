<?php

namespace wataridori\ChatworkSDK;

use wataridori\ChatworkSDK\Helper\Text;

class ChatworkUser extends ChatworkBase
{
    public $account_id;
    public $role = '';
    public $name = '';
    public $chatwork_id = '';
    public $organization_id = '';
    public $organization_name = '';
    public $department = '';
    public $avatar_image_url = '';

    protected $chatworkApi;

    /**
     * @param array|string $account
     * @param string $name
     * @param string $avatar_image_url
     */
    public function __construct($account, $name = '', $avatar_image_url = '')
    {
        if (is_array($account)) {
            foreach ($account as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        } elseif (is_numeric($account)) {
            $this->accountId = $account;
            $this->name = $name;
            $this->avatar_image_url = $avatar_image_url;
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
            'chatwork_id' => $this->chatwork_id,
            'organization_id' => $this->organization_id,
            'organization_name' => $this->organization_name,
            'department' => $this->department,
            'avatar_image_url' => $this->avatar_image_url
        ];
    }
}