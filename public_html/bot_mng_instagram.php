<?php

require "../vendor/autoload.php";
$user_id = '';

$botService = new \bot\BotService(
    new \bot\Bot(
        \bot\BotInstagramRepository::class,
        $command,
        [
            'username' => '',
            'password' => ''
        ]
    )
);

$botService->getRepository()->init($botService->getBot()->getParams());
$messages = $botService->getRepository()->getMessage($botService->getBot()->getParams());
$command = $messages[0]->message;
$botService
    ->setEvent(['start'], function ($bot) {
        $response = [
            'message' => 'Выберите или напишите одину из цифр... (1, 2, 3)'
        ];
        return $response;
    });
