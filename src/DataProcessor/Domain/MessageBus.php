<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 11/07/2017
 * Time: 19:50
 */

namespace Mpwar\DataProcessor\Domain;


interface MessageBus
{
    public function dispatch(String $message, DomainEvent $event);
}