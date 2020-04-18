<?php

include '../vendor/autoload.php';

try {
    $controller = new \AutoCode\Thinkphp\ControllerGenerator('App\\code', 'test');

    echo $controller;
}catch (\Throwable $e){
    echo $e->getMessage().PHP_EOL;
    echo $e->getLine().PHP_EOL;
    echo $e->getFile().PHP_EOL;
}
