<?php
include '../vendor/autoload.php';

try {
    $table = new \AutoCode\DateBase\Table('tableName', 'App\\Model', './');
    $table->setReadonly(['read1', 'read2']);
    $table->setAutoWriteTimestamp('auto');
    $table->setSoftDelete('delete_pro');
    $column = new \AutoCode\DateBase\Column('test_pro', \AutoCode\PhpType::STRING, \AutoCode\DateBase\ColumnType::VARCHAR);
    $column->setSize(50);
    $column->setComment('数据库属性: '.$column->getColumnName());
    $table->addColumn($column);
    new \AutoCode\Thinkphp\BaseModule\Entity\ModelGenerator($table);
}catch (\Throwable $e){
    echo $e->getMessage().PHP_EOL;
    echo 'ERROR: '.$e->getFile().'  '.$e->getLine().PHP_EOL;
}
