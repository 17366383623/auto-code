<?php
include '../vendor/autoload.php';

try {
    $fileSys = new \FileSystem\AutoRun('jh_');
}catch (\Throwable $e) {
    echo $e->getMessage().PHP_EOL;
    echo $e->getFile().'  '.$e->getLine().PHP_EOL;
}