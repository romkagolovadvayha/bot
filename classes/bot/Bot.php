<?php

namespace bot;

class Bot {

    private $command;
    private $repository;
    private $user_id;

    public function __construct($repository, $command, $user_id) {
        $this->repository = $repository;
        $this->command = $command;
        $this->user_id = $user_id;
    }

    public function getRepository() {
        return $this->repository;
    }

    public function getCommand() {
        return $this->command;
    }
    public function getUserId() {
        return $this->user_id;
    }

}
