<?php

namespace Mpwar\DataProcessor\Infrastructure;

use Mpwar\DataProcessor\Domain\Event\DomainEvent;
use Mpwar\DataProcessor\Domain\MessageBus;

class DefaultMessageBus implements MessageBus
{

    public function dispatch(String $message, DomainEvent $event)
    {
        echo json_encode($event, JSON_PRETTY_PRINT);
        return;
    }
}
