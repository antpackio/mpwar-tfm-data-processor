<?php

namespace Mpwar\DataProcessor\Domain;

use Mpwar\DataProcessor\Domain\Event\DomainEvent;

interface MessageBus
{
    public function dispatch(String $eventName, DomainEvent $event);
}