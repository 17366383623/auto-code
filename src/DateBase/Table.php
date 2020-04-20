<?php


namespace AutoCode\DateBase;


use http\Exception\RuntimeException;

class Table
{
    /**
     * @var array|null $columns
     */
    private ?array $columns;

    /**
     * @var string $tableName
     */
    private string $tableName;

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @param string $name
     */
    public function setTableName(string $name): void
    {
        $this->tableName = $name;
    }

    /**
     * @return array|null
     */
    public function getColumn(): ?array
    {
        return $this->columns;
    }

    /**
     * @param array $column
     */
    public function setColumn(array $column): void
    {
        foreach ($column as $v){
            if(!$v instanceof Column){
                throw new RuntimeException("the current column is not instance of Column");
            }
        }
        $this->columns = $column;
    }

    /**
     * @param Column $col
     */
    public function addColumn(Column $col): void
    {
        $this->columns[$col->getColumnName()] = $col;
    }

    /**
     * @param string $name
     */
    public function removeColumn(string $name): void
    {
        $columns = $this->columns;
        if(!isset($columns[$name])){
            throw new RuntimeException("column {$name} is not exist");
        }
        unset($columns[$name]);
        $this->columns = $columns;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasColumn(string $name): bool
    {
        if(isset($this->columns[$name])){
            return true;
        }
        return false;
    }
}