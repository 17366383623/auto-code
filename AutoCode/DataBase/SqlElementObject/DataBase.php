<?php

namespace AutoCode\DataBase\SqlElementObject;

use AutoCode\DataBase\DataBaseGeneric\TableGeneric;

/**
 * 数据库对象
 * Class DataBase
 * @package AutoCode\SqlElementObject
 */
class DataBase
{
    /**
     * @var string $name
     */
    private $name;

    /**
     * @var TableGeneric $tables
     */
    private $tables;

    /**
     * @var string
     */
    private $prefix = '';

    /**
     * @var string $comment
     */
    private $comment = '';

    /**
     * DataBase constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->setName($name);
        $this->setTables(new TableGeneric());
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    private function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return TableGeneric
     */
    public function getTables(): TableGeneric
    {
        return $this->tables;
    }

    /**
     * @param TableGeneric $tables
     */
    public function setTables(TableGeneric $tables): void
    {
        $this->tables = $tables;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $prefix
     */
    public function setPrefix(string $prefix): void
    {
        $this->prefix = $prefix;
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }
}