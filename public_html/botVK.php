<?php

require "../vendor/autoload.php";

$obj = json_decode(file_get_contents('php://input'));

if (empty($obj)) {
    throw new \Exception('not input data',450);
}

$body = $obj->object->text;
$user_id = $obj->object->from_id;

$body = str_replace('  ', ' ', $body);
$body = mb_strtolower($body);
$command = trim($body);

if (!empty($obj->object->payload)) {
    $payload = json_decode($obj->object->payload);
    $command = $payload->button;
}

$botService = new \bot\BotService(
    new \bot\Bot(
        \bot\BotVKRepository::class,
        $command,
        $user_id
    )
);
$botService
    ->setEvent(['начать', 'хочу права', 'подарок'], function ($bot) {
        $response = [
            'message' => 'Выберите или напишите одину из цифр... (1, 2, 3)',
            'buttons' => [
                [
                    ['title' => '1', 'color' => 'primary', 'code' => 'podarok_1'],
                    ['title' => '2', 'color' => 'primary', 'code' => 'podarok_2'],
                    ['title' => '3', 'color' => 'primary', 'code' => 'podarok_3']
                ]
            ]
        ];
        return $response;
    })
    ->setEvent(['1', '2', '3', 'podarok_1', 'podarok_2', 'podarok_3'], function ($bot) {
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
                ['title' => 'A', 'color' => 'primary', 'code' => 'category_A'],
                ['title' => 'B', 'color' => 'primary', 'code' => 'category_B'],
                ['title' => 'C', 'color' => 'primary', 'code' => 'category_C'],
            ],
            [
                ['title' => 'Назад', 'color' => 'primary', 'code' => 'back_category']
            ],
            [
                ['title' => 'Отзывы', 'color' => 'primary', 'code' => 'button_reviews']
            ]
        ];
        return $response;
    })
    ->setEvent(['а', 'a', 'category_A'], function ($bot) {
        $response = [
            'message' => ''
                . 'Помимо очного обучения у нас есть дистанционное, все наши ученики остались довольны, некоторые писали о своем обучении: https://vk.com/topic-101286324_32727316 '
                . \Config::$PER_VK . 'Видео отзывы можно посмотреть на сайте: https://mg.avtoinline.com/ '
                . \Config::$PER_VK . 'Посмотрите как проходят наши уроки, если у вас в руках телефон или планшет, то переходите по ссылке: cab.autoinline.com, если вы сидите за компьютером: https://vk.com/app5201558_-101286324 '
                . \Config::$PER_VK . \Config::$PER_VK . 'Обучаясь у нас вы не только получите права, но и останетесь довольны.',
            'attachment' => 'video-101286324_456239082',
            'buttons' => [
                ['title' => 'Назад', 'color' => 'primary', 'code' => 'back_category']
            ]
        ];
        return $response;
    })
    ->setEvent(['c', 'ц', 'с', 'category_C'], function ($bot) {
        $response = [
            'message' => ''
                . 'Помимо очного обучения у нас есть дистанционное, все наши ученики остались довольны, некоторые писали о своем обучении: https://vk.com/topic-101286324_32727316 '
                . \Config::$PER_VK . 'Видео отзывы можно посмотреть на сайте: https://mg.avtoinline.com/ '
                . \Config::$PER_VK . 'Посмотрите как проходят наши уроки, если у вас в руках телефон или планшет, то переходите по ссылке: cab.autoinline.com, если вы сидите за компьютером: https://vk.com/app5201558_-101286324 '
                . \Config::$PER_VK . \Config::$PER_VK . 'Обучаясь у нас вы не только получите права, но и останетесь довольны.',
            'attachment' => 'video-101286324_456239082',
            'buttons' => [
                ['title' => 'Назад', 'color' => 'primary', 'code' => 'back_category']
            ]
        ];
        return $response;
    })
    ->setEvent(['b', 'б', 'в', 'category_B'], function ($bot) {
        $response = [
            'message' => ''
                . 'Помимо очного обучения у нас есть дистанционное, все наши ученики остались довольны, некоторые писали о своем обучении: https://vk.com/topic-101286324_32727316 '
                . \Config::$PER_VK . 'Видео отзывы можно посмотреть на сайте: https://mg.avtoinline.com/ '
                . \Config::$PER_VK . 'Посмотрите как проходят наши уроки, если у вас в руках телефон или планшет, то переходите по ссылке: cab.autoinline.com, если вы сидите за компьютером: https://vk.com/app5201558_-101286324 '
                . \Config::$PER_VK . \Config::$PER_VK . 'Обучаясь у нас вы не только получите права, но и останетесь довольны.',
            'attachment' => 'video-101286324_456239082',
            'buttons' => [
                ['title' => 'Назад', 'color' => 'primary', 'code' => 'back_category']
            ]
        ];
        return $response;
    })
    ->setEvent(['button_reviews'], function ($bot) {
        $response = [
            'message' => 'Видео отзывы можно посмотреть на сайте: https://mg.avtoinline.com/',
            'attachment' => 'video-101286324_456239082',
            'buttons' => [
                ['title' => 'Назад', 'color' => 'primary', 'code' => 'back_category']
            ]
        ];
        return $response;
    });
