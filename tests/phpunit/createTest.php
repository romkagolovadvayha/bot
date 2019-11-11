<?php

class createTest extends PHPUnit_Framework_TestCase {

    public function testBot() {
        $bot = new \bot\Bot(\bot\BotVKRepository::class, 'help');
        $this->assertEquals($bot->getRepository(), \bot\BotVKRepository::class);
        $this->assertEquals($bot->getCommand(), 'help');
    }

}

?>
