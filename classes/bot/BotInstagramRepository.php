<?php

namespace bot;

class BotInstagramRepository
{

    private $instagram;

    public function __construct()
    {
    }

    public function init($botParams)
    {
        if (empty($botParams['username'])) {
            return false;
        }
        if (empty($botParams['password'])) {
            return false;
        }
        \InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
        $this->instagram = new \InstagramAPI\Instagram();
        $this->instagram->login($botParams['username'], $botParams['password']);
    }

    public function getMessage($botParams)
    {
    }

    public function getUserInfo($botParams)
    {

    }

}
