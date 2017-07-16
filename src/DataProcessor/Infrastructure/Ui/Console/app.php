<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new \Mpwar\DataProcessor\Infrastructure\Ui\DataProcessorServiceProvider());

return $app;