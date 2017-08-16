<?php

namespace Mpwar\DataProcessor\Infrastructure\Application;

use Mpwar\DataProcessor\Application\MessageBus;

class DebugMessageBus implements MessageBus
{

    public function dispatch(String $eventName, $event)
    {
        var_dump($eventName, $event);
    }
}
