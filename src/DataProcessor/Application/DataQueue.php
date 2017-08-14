<?php

namespace Mpwar\DataProcessor\Application;

interface DataQueue
{
    public function next(): array;
}
