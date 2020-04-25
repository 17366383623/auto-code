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
     * @var string $autoWriteTimestamp
     */
    private string $autoWriteTimestamp = '';

    /**
     * @var array $readonly
     */
    private array $readonly = [];

    /**
     * @var string $softDelete
     */
    private string $softDelete = '';

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
        $this->tableName = ucfirst($name);
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
     * getAutoWriteTimestamp
     */
    public function getAutoWriteTimestamp(): string
    {
        return $this->autoWriteTimestamp;
    }

    /**
     * @param string $autoWriteTimestamp
     */
    public function setAutoWriteTimestamp(string $autoWriteTimestamp): void
    {
        $this->autoWriteTimestamp = $autoWriteTimestamp;
    }

    /**
     * @return array
     */
    public function getReadonly(): array
    {
        return (bool)$this->readonly?$this->readonly:[];
    }

    /**
     * @param array $readonly
     */
    public function setReadonly(array $readonly):void
    {
        $this->readonly = $readonly;
    }

    /**
     * @return string
     */
    public function getSoftDelete():string
    {
        return $this->softDelete;
    }

    /**
     * @param string $softDelete
     */
    public function setSoftDelete(string $softDelete): void
    {
        $this->softDelete = $softDelete;
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