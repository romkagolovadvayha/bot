<?php

namespace bot;

class BotService
{

    /*
     * @var \bot\Bot
     */

    private $bot;
    private $repository;

    public function __construct($bot)
    {
        $this->bot = $bot;
        $classRepository = $bot->getRepository();
        $this->repository = new $classRepository();
    }


    public function setEvent($commands, $dataCallback)
    {
        if (!in_array($this->bot->getCommand(), $commands)) {
            return $this;
        }
        $response = $dataCallback($this->bot);
        if (!empty($response['message'])) {
            $this->repository->sendMessage($response, $this->bot->getParams());
        }
        return $this;
    }

    public function getRepository()
    {
        return $this->repository;
    }

    public function getBot()
    {
        return $this->bot;
    }
}
