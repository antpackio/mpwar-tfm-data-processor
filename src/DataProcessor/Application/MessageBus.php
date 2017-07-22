<?php

namespace Mpwar\DataProcessor\Application;

interface MessageBus
{
    public function dispatch(String $eventName, $event);
}