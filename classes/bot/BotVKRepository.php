<?php

namespace bot;

use VK\Client\VKApiClient;

class BotVKRepository
{

    private $VKApiClient;

    public function __construct()
    {
        $this->VKApiClient = new VKApiClient();
    }

    public function sendMessage($data, $botParams)
    {
        if (empty($botParams['user_id'])) {
            return false;
        }
        if (empty($botParams['access_token'])) {
            return false;
        }
        $params = [];
        $params['user_id'] = $botParams['user_id'];
        if (!empty($data['buttons'])) {
            $keyboard = [];
            $keyboard['one_time'] = true;
            $keyboard['buttons'] = [];
            foreach ($data['buttons'] as $buttons_arr) {
                $buttons_arr_ = [];
                foreach ($buttons_arr as $index => $button) {
                    $buttons_arr_[] = [
                        'action' => [
                            'type' => 'text',
                            'payload' => '{"button": "' . $button['code'] . '"}',
                            'label' => $button['title']
                        ],
                        'color' => $button['color']
                    ];
                }
                $keyboard['buttons'][] = $buttons_arr_;
            }
            $params['keyboard'] = json_encode($keyboard, JSON_UNESCAPED_UNICODE);;
        }
        if (empty($data['random_id'])) {
            $data['random_id'] = rand(111111111, 9999999999);
        }
        $params['random_id'] = $data['random_id'];
        if (!empty($data['sticker_id'])) {
            $params['sticker_id'] = $data['sticker_id'];
        }
        if (!empty($data['message'])) {
            $params['message'] = $data['message'];
        }
        if (!empty($data['attachment'])) {
            $params['attachment'] = $data['attachment'];
        }
        $response = $this->VKApiClient->messages()->send($botParams['access_token'], $params);
        return $response;
    }

    public function getUserInfo($botParams)
    {
        if (empty($botParams['user_id'])) {
            return false;
        }
        if (empty($botParams['access_token'])) {
            return false;
        }
        $response = $this->VKApiClient->users()->get($botParams['access_token'], [
            'user_ids' => [$botParams['user_id']]
        ]);
        return $response;
    }

}
