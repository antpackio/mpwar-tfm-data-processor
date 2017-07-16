<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

$console = new Symfony\Component\Console\Application();
$console->addCommands(
    [
        new \Mpwar\DataProcessor\Infrastructure\Ui\Console\Command\ProcessQueue(
            $app['data_processor']
        )
    ]
);

return $console;