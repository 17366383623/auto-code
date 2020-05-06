<?php
include '../vendor/autoload.php';

try {
    $table = new \AutoCode\DateBase\Table('tableName', 'App\\Model', './');
    $table->setSoftDelete('soft_delete');
    $table->setAutoWriteTimestamp('auto_timestamp');
    $column = new \AutoCode\DateBase\Column('test_pro', \AutoCode\PhpType::STRING, \AutoCode\DateBase\ColumnType::VARCHAR);
    $column->setSize(50);
    $column->setDefaultValue(0);
    $column->setPrimary();
    $column->setComment('数据库属性: '.$column->getColumnName());
    $table->addColumn($column);
    $database = new \AutoCode\DateBase\DataBase('testDataBase');
    $database->setPrefix('th_');
    $database->addTable($table);
    var_dump(\AutoCode\DateBase\SqlGenerator::generator($database));
    // \AutoCode\Thinkphp\AutoRun::run($database, [
    //     'root_path' => realpath('./'),
    //     'root_namespace' => 'Test'
    // ]);
}catch (\Throwable $e){
    echo $e->getMessage().PHP_EOL;
    echo 'ERROR: '.$e->getFile().'  '.$e->getLine().PHP_EOL;
}
