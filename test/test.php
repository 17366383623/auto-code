<?php
include '../vendor/autoload.php';

try {
    $table = new \AutoCode\DateBase\Table();
    $table->setTableName('tableName');
    $table->setReadonly(['read1', 'read2']);
    $table->setAutoWriteTimestamp('auto');
    $table->setSoftDelete('delete_pro');
    $column = new \AutoCode\DateBase\Column();
    $column->setColumnName('test_pro');
    $column->setPhpType(\AutoCode\PhpType::STRING);
    $column->setType(\AutoCode\DateBase\ColumnType::VARCHAR);
    $column->setSize(50);
    $column->setComment([
        '数据库属性: '.$column->getColumnName(),
        ' ',
        '@var '.$column->getPhpType()
    ]);
    $table->addColumn($column);
    new \AutoCode\Thinkphp\BaseModule\Entity\ModelGenerator('./','App\\Model', $table);
}catch (\Throwable $e){
    echo $e->getMessage().PHP_EOL;
    echo 'ERROR: '.$e->getFile().'  '.$e->getLine().PHP_EOL;
}
