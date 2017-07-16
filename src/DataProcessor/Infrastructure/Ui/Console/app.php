<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

$app = new Silex\Application();

$config = \Symfony\Component\Yaml\Yaml::parse(file_get_contents(__DIR__ . '/../../../../../resources/config/config.yaml'));

foreach ($config as $key => $value) {
    $app[$key] = $value;
}

$app->register(new \Silex\Provider\DoctrineServiceProvider());
$app->register(new \Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider());
$app->register(new \Aws\Silex\AwsServiceProvider());
$app->register(new \Mpwar\DataProcessor\Infrastructure\Ui\DataProcessorServiceProvider());

return $app;