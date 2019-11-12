<?php

namespace bot;

class Bot {

    private $command;
    private $repository;
    private $params;

    public function __construct($repository, $command, $params) {
        $this->repository = $repository;
        $this->command = $command;
        $this->params = $params;
    }

    public function getRepository() {
        return $this->repository;
    }

    public function getCommand() {
        return $this->command;
    }
    public function getParams() {
        return $this->params;
    }

}
