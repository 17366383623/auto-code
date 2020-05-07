<?php


namespace AutoCode\DateBase;


class DatabaseQuickGenerator
{
    /**
     * @param string $databaseName
     * @param array $databaseArray
     * @param string $prefix
     * @return DataBase
     */
    public static function generator(string $databaseName, array $databaseArray, string $prefix = ''): DataBase
    {
        $database = new DataBase($databaseName);
        $database->setPrefix($prefix);
        foreach ($databaseArray as $name => $tableArr){
            $table = new Table($name);
            $table->setSoftDelete('delete_at');
            $table->setAutoWriteTimestamp('update_at');
            foreach ($tableArr as $col){
                $column = new Column($col['title'], $col['phpType'], $col['type']);
                $column->setSize($col['size']);
                $column->setComment($col['comment']);
                if(isset($col['primary']) && $col['primary']===TRUE){
                    $column->setPrimary();
                }
                if(isset($col['auto_increment']) && $col['auto_increment']===TRUE){
                    $column->setAutoIncrement();
                }
                $table->addColumn($column);
            }
            $database->addTable($table);
        }
    }
}