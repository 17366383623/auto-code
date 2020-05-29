<?php
include '../vendor/autoload.php';

try {
    $table = new \AutoCode\DataBase\SqlElementObject\Table('test_auto', './', 'app', '测试表');
    // 列
    $column = new \AutoCode\DataBase\SqlElementObject\Column('test_col', \AutoCode\DataBase\Utility\SqlTypeEnum::__VARCHAR__, '50');
    $column->setComment('主键');
    $property = new \AutoCode\Auto\Utility\Property($column);
    $property->setMapType(\AutoCode\Auto\Utility\Enum\TransformType::__BOOLEAN__);
    $property->setReadOnly();
    $property->getSqlColumn()->setIsPrimary();
    $propertyGeneric = new \AutoCode\Auto\Utility\Generic\PropertyGeneric();
    $propertyGeneric->push($property);
    $table->setPropertyGeneric($propertyGeneric);
    $database = new \AutoCode\DataBase\SqlElementObject\DataBase('lezhi');
    $database->setPrefix('jh_');
    $tableGeneric = new \AutoCode\DataBase\DataBaseGeneric\TableGeneric();
    $tableGeneric->push($table);
    $database->setTables($tableGeneric);
    new \AutoCode\Auto\Thinkphp\AutoRun($database, true);
}catch (\Throwable $e){
    echo $e->getMessage().PHP_EOL;
    echo 'ERROR: '.$e->getFile().'  '.$e->getLine().PHP_EOL;
}
