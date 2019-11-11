<?php

require "../vendor/autoload.php";

$command = 'podarok_1';
$user_id = '33610634';

$botService = new \bot\BotService(
    new \bot\Bot(
        \bot\BotVKRepository::class,
        $command,
        $user_id
    )
);
$botService->setEvent(['привет', 'как'], function () {
    return [
        'message' => '',
        'attachment' => [],
        'buttons' => [
            [
                [
                    'title' => 'Назад',
                    'color' => 'primary',
                    'code' => 'back_category'
                ]
            ]
        ],
    ];
});
$botService->setEvent(['1', '2', '3', 'podarok_1', 'podarok_2', 'podarok_3'], function ($bot) {
    $botVKRepository = new \bot\BotVKRepository();
    $userInfo = $botVKRepository->getUserInfo($bot->getUserId());
    $userName = $userInfo[0]['first_name'];
    $date = date("d.m.Y", strtotime("+7 days"));
    $messages = [
        [
            'message' => "Поздравляем вас, $userName! Вы получаете мед осмотр за счет автошколы. "
                . \Config::$PER_VK . "Акция действует при заключении договора до $date. "
                . \Config::$PER_VK . \Config::$PER_VK . "Какая категория обучения вас интересует (A, B, C)?",
            'attachment' => 'photo-101286324_456240102'
        ],
        [
            'message' => "Поздравляем вас, $userName!Вы получаете скидку на обучение 1000 рублей. "
                . \Config::$PER_VK . "Акция действует при заключении договора до $date. "
                . \Config::$PER_VK . \Config::$PER_VK . "Какая категория обучения вас интересует(A, B, C)? ",
            'attachment' => 'photo-101286324_456240103'
        ],
        [
            'message' => "Поздравляем вас, $userName!Вы получаете 2 занятия с инструктором бесплатно. "
                . \Config::$PER_VK . "Акция действует при заключении договора до $date. "
                . \Config::$PER_VK . \Config::$PER_VK . "Какая категория обучения вас интересует(A, B, C)? ",
            'attachment' => 'photo-101286324_456240101'
        ]
    ];
    $index = rand(0, count($messages) - 1);
    $response = $messages[$index];
    $response['buttons'] = [
        [
            [
                'title' => 'A',
                'color' => 'primary',
                'code' => 'category_A'
            ],
            [
                'title' => 'B',
                'color' => 'primary',
                'code' => 'category_B'
            ],
            [
                'title' => 'C',
                'color' => 'primary',
                'code' => 'category_C'
            ],
        ],
        [
            [
                'title' => 'Назад',
                'color' => 'primary',
                'code' => 'back_category'
            ]
        ],
        [
            [
                'title' => 'Отзывы',
                'color' => 'primary',
                'code' => 'button_reviews'
            ]
        ]
    ];
    return $response;
});
