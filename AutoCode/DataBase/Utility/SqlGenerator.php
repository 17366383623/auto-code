<?php

namespace AutoCode\DataBase\Utility;

use AutoCode\DataBase\SqlElementObject\DataBase;
use AutoCode\Common\StringHelper;
use AutoCode\DataBase\SqlElementObject\Table;

/**
 * sql语句生成器
 * Class SqlGenerator
 * @package AutoCode\Utility
 */
class SqlGenerator
{
    /**
     * @param DataBase $database
     * @return string
     */
    public static function handle(DataBase $database): string
    {
        $str    = '';
        $tables = $database->getTables();
        foreach ($tables as $table) {
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
        // 获取表名
        $tableName  = lcfirst(StringHelper::snake($table->getName()));
        $primaryKey = [];
        $sqlStr     = '';
        $sqlStr     .= "DROP TABLE IF EXISTS `{$tableName}`;".PHP_EOL;
        $sqlStr     .= "CREATE TABLE `{$tableName}` (".PHP_EOL;
        foreach ($table->getPropertyGeneric() as $col) {
            if ($col->getSqlColumn()->isPrimary()) {
                $primaryKey[] = "`{$col->getSqlColumn()->getName()}`";
            }
            $sqlStr .= "`{$col->getSqlColumn()->getName()}` {$col->getSqlColumn()->getType()}({$col->getSqlColumn()->getSize()}) ";
            if (!$col->getSqlColumn()->isNullable()) {
                $sqlStr .= 'NOT NULL ';
            }
            if ($col->getSqlColumn()->isAutoIncrement()) {
                $sqlStr .= 'AUTO_INCREMENT ';
            }
            $isInt = in_array($col->getSqlColumn()->getType(), ['INT', 'SMALLINT', 'TINYINT']) ? TRUE : FALSE;
            if ($col->getSqlColumn()->getDefaultValue() !== NULL) {
                if (!$isInt) {
                    $sqlStr .= "DEFAULT '{$col->getSqlColumn()->getDefaultValue()}' ";
                } else {
                    $sqlStr .= "DEFAULT {$col->getSqlColumn()->getDefaultValue()} ";
                }
            }
            $comment = $col->getSqlColumn()->getComment();
            $sqlStr  .= "COMMENT '{$comment}',".PHP_EOL;
        }
        if ($primaryKey) {
            $primary = implode(',', $primaryKey);
            $sqlStr  .= "PRIMARY KEY ({$primary}) USING BTREE,".PHP_EOL;
        }
        if ($sqlStr[strlen($sqlStr) - 2] === ',') {
            $sqlStr = substr($sqlStr, 0, -2).PHP_EOL;
        }
        $comment = $table->getComment() ?? $table->getName();
        $sqlStr  .= ") ENGINE={$table->getEngine()} DEFAULT CHARSET=utf8mb4 COMMENT='{$comment}';".PHP_EOL;
        return $sqlStr;
    }
}