<?php


namespace AutoCode\DateBase;

use AutoCode\Utility\StringHelper;

/**
 * Class SqlGenerator
 * @package AutoCode\DateBase
 */
class SqlGenerator
{
    /**
     * @param DataBase $database
     * @return string
     */
    public static function generator(DataBase $database): string
    {
        $str = '';
        foreach ($database->getTables() as $table){
            $str .= self::generatorColumn($table, $database);
        }
        return $str;
    }

    /**
     * @param Table $table
     * @param DataBase $databaseName
     * @return string
     */
    private static function generatorColumn(Table $table, DataBase $databaseName): string
    {
        $tableName = $databaseName->getPrefix().lcfirst(StringHelper::snake($table->getTableName()));
        $primaryKey = [];
        $sqlStr = '';
        $sqlStr .= "DROP TABLE IF EXISTS `{$databaseName->getName()}.{$tableName}`;".PHP_EOL;
        $sqlStr .= "CREATE TABLE `{$databaseName->getName()}".'.'."{$tableName}` (".PHP_EOL;
        foreach ($table->getColumn() as $col){
            if($col->isPrimary()){
                $primaryKey[] = "`{$col->getColumnName()}`";
            }
            $sqlStr .= "`{$col->getColumnName()}` {$col->getType()}({$col->getSize()}) ";
            if(!$col->getIsNullable()){
                $sqlStr .= 'NOT NULL ';
            }
            if($col->getDefaultValue() !== null){
                if(is_string($col->getDefaultValue())){
                    $sqlStr .= "DEFAULT '{$col->getDefaultValue()}' ";
                } else if(is_int($col->getDefaultValue())){
                    $sqlStr .= "DEFAULT {$col->getDefaultValue()} ";
                } else {
                    throw new \RuntimeException('column default value must be int | string');
                }
            }
            $comment = ($col->getComment())[0] ?? '';
            $sqlStr .= "COMMENT '{$comment}',".PHP_EOL;
        }
        if((bool)$table->getSoftDelete()){
            $sqlStr .= "`{$table->getSoftDelete()}` varchar(20) DEFAULT '' COMMENT '软删除',".PHP_EOL;
        }
        if((bool)$table->getAutoWriteTimestamp()){
            $sqlStr .= "`{$table->getAutoWriteTimestamp()}` varchar(30) NOT NULL COMMENT '自动时间戳',".PHP_EOL;
        }
        if($primaryKey){
            $primary = implode(',',$primaryKey);
            $sqlStr .= "PRIMARY KEY ({$primary}) USING BTREE,".PHP_EOL;
        }
        if(substr($sqlStr, strlen($sqlStr)-2, 1) === ','){
            $sqlStr = substr($sqlStr, 0, strlen($sqlStr)-2).PHP_EOL;
        }
        $comment = $databaseName->getComment()??$databaseName->getName();
        $sqlStr .= ") ENGINE={$databaseName->getEngine()} DEFAULT CHARSET=utf8mb4 COMMENT='{$comment}';".PHP_EOL;
        return $sqlStr;
    }
}