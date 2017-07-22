<?php

namespace Mpwar\DataProcessor\Infrastructure\Application;

use Mpwar\DataProcessor\Application\MessageBus;

class DefaultMessageBus implements MessageBus
{

    public function dispatch(String $eventName, $event)
    {
        echo json_encode($event, JSON_PRETTY_PRINT);
        return;
    }
}
