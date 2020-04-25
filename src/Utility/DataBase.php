<?php


namespace AutoCode\Utility;


use AutoCode\DateBase\ColumnType;
use http\Exception\RuntimeException;

class DataBase
{
    /**
     * @param string $type
     * @return string
     */
    public static function DataBaseTypeToPhpType(string $type): string
    {
        if(in_array($type, [ColumnType::CHAR, ColumnType::VARCHAR, ColumnType::TEXT, ColumnType::DATE, ColumnType::DATETIME, ColumnType::TIMESTAMP])){
            return 'string';
        }
        if(in_array($type, [ColumnType::INT, ColumnType::TINYINT, ColumnType::SMALLINT])){
            return 'int';
        }
        if(in_array($type, [ColumnType::FLOAT, ColumnType::DOUBLE])){
            return 'float';
        }
        throw new RuntimeException("$type is not in \AutoCode\DateBase\ColumnTyp");
    }
}