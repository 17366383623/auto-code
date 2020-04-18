<?php

include '../vendor/autoload.php';

try {
    $controller = new \AutoCode\Thinkphp\ControllerGenerator('App', 'test', []);
    $controller->setStrict();
    var_dump($controller);
}catch (\Throwable $e){
    echo $e->getMessage().PHP_EOL;
    echo $e->getLine().PHP_EOL;
    echo $e->getFile().PHP_EOL;
}
