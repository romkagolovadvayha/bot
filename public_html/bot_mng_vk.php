<?php
echo 'ok';
require "../vendor/autoload.php";

$obj = json_decode(file_get_contents('php://input'));

if (empty($obj)) {
    exit;
}

$user_id = $obj->object->from_id;

$body = $obj->object->text;
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
        [
            'user_id' => $user_id,
            'access_token' => ''
        ]
    )
);
$botService
    ->setEvent(['начать', 'хочу права', 'подарок', 'button_start'], function ($bot) {
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
        $userInfo = $botVKRepository->getUserInfo($bot->getParams());
        $userName = $userInfo[0]['first_name'];
        $date = date("d.m.Y", strtotime("+7 days"));
        $messages = [
            [
                'message' => "Поздравляем вас, $userName! Вы получаете мед осмотр за счет автошколы. "
                    . \Config::$PER_VK . "Акция действует при заключении договора до $date. "
                    . \Config::$PER_VK . \Config::$PER_VK . "Какая категория обучения вас интересует (A, B, C)?",
                'attachment' => 'photo-101286324_457240459'
            ],
            [
                'message' => "Поздравляем вас, $userName! Вы получаете скидку на обучение 1000 рублей. "
                    . \Config::$PER_VK . "Акция действует при заключении договора до $date. "
                    . \Config::$PER_VK . \Config::$PER_VK . "Какая категория обучения вас интересует(A, B, C)? ",
                'attachment' => 'photo-101286324_457240460'
            ],
            [
                'message' => "Поздравляем вас, $userName! Вы получаете 2 занятия с инструктором бесплатно. "
                    . \Config::$PER_VK . "Акция действует при заключении договора до $date. "
                    . \Config::$PER_VK . \Config::$PER_VK . "Какая категория обучения вас интересует(A, B, C)? ",
                'attachment' => 'photo-101286324_457240458'
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
                ['title' => 'Инструктора', 'color' => 'primary', 'code' => 'button_instructor'],
                ['title' => 'Отзывы', 'color' => 'primary', 'code' => 'button_reviews'],
            ],
            [
                ['title' => 'Смотреть 1 урок', 'color' => 'primary', 'code' => 'button_lesson_view'],
            ],
            [
                ['title' => 'Назад', 'color' => 'negative', 'code' => 'button_start']
            ]
        ];
        return $response;
    })
    ->setEvent(['а', 'a', 'category_A'], function ($bot) {
        $response = [
            'message' => ''
                . 'Помимо очного обучения у нас есть дистанционное, это наиболее современная программа доказавшая свою эффективность. Посмотрите как проходят наши уроки и у вас не останется сомнений. Так же занятия можно совмещать.'
                . \Config::$PER_VK . 'Со своей стороны мы гарантируем: Полную поддержку до получения прав.'
                . \Config::$PER_VK . 'Фиксированную цену без каких либо доплат.'
                . \Config::$PER_VK . 'Рассрочку платежа до 5 месяцев.'
                . \Config::$PER_VK . 'Свободный график обучения.'
                . \Config::$PER_VK . 'Индивидуальный подход к каждому.'
                . \Config::$PER_VK . 'Обучаясь у нас вы нетолько получите права, но и останетесь довольны.',
            'attachment' => 'video-101286324_456239082',
            'buttons' => [
                [
                    ['title' => 'Смотреть 1 урок', 'color' => 'primary', 'code' => 'button_lesson_view'],
                ],
                [
                    ['title' => 'Инструктора', 'color' => 'primary', 'code' => 'button_instructor'],
                    ['title' => 'Отзывы', 'color' => 'primary', 'code' => 'button_reviews'],
                ],
                [
                    ['title' => 'Назад', 'color' => 'negative', 'code' => 'button_start']
                ]
            ]
        ];
        return $response;
    })
    ->setEvent(['c', 'ц', 'с', 'category_C'], function ($bot) {
        $response = [
            'message' => ''
                . 'Помимо очного обучения у нас есть дистанционное, это наиболее современная программа доказавшая свою эффективность. Посмотрите как проходят наши уроки и у вас не останется сомнений. Так же занятия можно совмещать.'
                . \Config::$PER_VK . 'Со своей стороны мы гарантируем: Полную поддержку до получения прав.'
                . \Config::$PER_VK . 'Фиксированную цену без каких либо доплат.'
                . \Config::$PER_VK . 'Рассрочку платежа до 5 месяцев.'
                . \Config::$PER_VK . 'Свободный график обучения.'
                . \Config::$PER_VK . 'Индивидуальный подход к каждому.'
                . \Config::$PER_VK . 'Обучаясь у нас вы нетолько получите права, но и останетесь довольны.',
            'attachment' => 'video-101286324_456239082',
            'buttons' => [
                [
                    ['title' => 'Смотреть 1 урок', 'color' => 'primary', 'code' => 'button_lesson_view'],
                ],
                [
                    ['title' => 'Инструктора', 'color' => 'primary', 'code' => 'button_instructor'],
                    ['title' => 'Отзывы', 'color' => 'primary', 'code' => 'button_reviews'],
                ],
                [
                    ['title' => 'Назад', 'color' => 'negative', 'code' => 'button_start']
                ]
            ]
        ];
        return $response;
    })
    ->setEvent(['b', 'б', 'в', 'category_B'], function ($bot) {
        $response = [
            'message' => ''
                . 'Помимо очного обучения у нас есть дистанционное, это наиболее современная программа доказавшая свою эффективность. Посмотрите как проходят наши уроки и у вас не останется сомнений. Так же занятия можно совмещать.'
                . \Config::$PER_VK . 'Со своей стороны мы гарантируем: Полную поддержку до получения прав.'
                . \Config::$PER_VK . 'Фиксированную цену без каких либо доплат.'
                . \Config::$PER_VK . 'Рассрочку платежа до 5 месяцев.'
                . \Config::$PER_VK . 'Свободный график обучения.'
                . \Config::$PER_VK . 'Индивидуальный подход к каждому.'
                . \Config::$PER_VK . 'Обучаясь у нас вы нетолько получите права, но и останетесь довольны.',
            'attachment' => 'video-101286324_456239082',
            'buttons' => [
                [
                    ['title' => 'Смотреть 1 урок', 'color' => 'primary', 'code' => 'button_lesson_view'],
                ],
                [
                    ['title' => 'Инструктора', 'color' => 'primary', 'code' => 'button_instructor'],
                    ['title' => 'Отзывы', 'color' => 'primary', 'code' => 'button_reviews'],
                ],
                [
                    ['title' => 'Назад', 'color' => 'negative', 'code' => 'button_start']
                ]
            ]
        ];
        return $response;
    })
    ->setEvent(['button_reviews'], function ($bot) {
        $response = [
            'message' => 'Все наши ученики остались довольны своим обучением некоторые писали о том как получали права: https://vk.com/topic-101286324_32727316'
                . \Config::$PER_VK . 'Видео отзывы можно посмотреть на сайте: https://mg.avtoinline.com/',
            'attachment' => 'photo-101286324_457240463',
            'buttons' => [
                [
                    ['title' => 'Инструктора', 'color' => 'primary', 'code' => 'button_instructor'],
                    ['title' => 'Смотреть 1 урок', 'color' => 'primary', 'code' => 'button_lesson_view'],
                ],
                [
                    ['title' => 'Назад', 'color' => 'negative', 'code' => 'button_start']
                ]
            ]
        ];
        return $response;
    })
    ->setEvent(['button_lesson_view'], function ($bot) {
        $response = [
            'message' => 'если у вас в руках телефон или планшет, то переходите по ссылке: cab.autoinline.com, если вы сидите за компьютером: https://vk.com/app5201558_-101286324',
            'buttons' => [
                [
                    ['title' => 'Отзывы', 'color' => 'primary', 'code' => 'button_reviews'],
                    ['title' => 'Инструктора', 'color' => 'primary', 'code' => 'button_instructor'],
                ],
                [
                    ['title' => 'Назад', 'color' => 'negative', 'code' => 'button_start']
                ],
            ],
            'attachment' => 'photo-101286324_457240461',
        ];
        return $response;
    })
    ->setEvent(['button_instructor'], function ($bot) {
        $response = [
            'message' => ''
                . 'Наши инструкторы настоящие профессионалы своего дела. Именно от их мастерства зависит то, с какими навыками вы будете самостоятельно управлять автомобилем.'
                . \Config::$PER_VK . 'Короткий обзор.'
                . \Config::$PER_VK . '1. Иван: https://vk.com/wall-101286324_6644'
                . \Config::$PER_VK . 'https://vk.com/wall-101286324_5592'
                . \Config::$PER_VK . '2. Максим Эдуардович: https://vk.com/wall-101286324_6636'
                . \Config::$PER_VK . '3. Дмитрий: https://vk.com/wall-101286324_6628'
                . \Config::$PER_VK . '4. Геннадий Васильевич: https://vk.com/wall-101286324_6618'
                . \Config::$PER_VK . '5. Дмитрий Владимирович: https://vk.com/wall-101286324_6630'
                . \Config::$PER_VK . '6. Владимир Николаевич: https://vk.com/wall-101286324_6647'
                . \Config::$PER_VK . '7. Сергей Владиславович: https://vk.com/wall-101286324_6649'
                . \Config::$PER_VK . '8. Андрей https://vk.com/wall-101286324_5567',
            'buttons' => [
                [
                    ['title' => 'Отзывы', 'color' => 'primary', 'code' => 'button_reviews'],
                    ['title' => 'Смотреть 1 урок', 'color' => 'primary', 'code' => 'button_lesson_view'],
                ],
                [
                    ['title' => 'Назад', 'color' => 'negative', 'code' => 'button_start']
                ],
            ],
            'attachment' => 'photo-101286324_457240462',
        ];
        return $response;
    });
