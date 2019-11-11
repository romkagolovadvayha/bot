<?php

class eventTest extends PHPUnit_Framework_TestCase {

    public function testEventIgnore() {
        $botService = new \bot\BotService(
                new \bot\Bot(\bot\BotVKRepository::class, 'info')
        );
        $result = TRUE;
        $botService->setEvent('help', function () {
            $result = FALSE;
        });
        $this->assertTrue($result);
    }

    public function testEventNotIgnore() {
        $botService = new \bot\BotService(
                new \bot\Bot(\bot\BotVKRepository::class, 'info')
        );
        $result = FALSE;
        $botService->setEvent('info', function () {
            $result = TRUE;
        });
        $this->assertTrue($result);
    }

}

?>
