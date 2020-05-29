<?php


namespace AutoCode\DateBase;


use http\Exception\RuntimeException;

class DataBase
{
    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $engine
     */
    private $engine = 'Innodb';

    /**
     * @var string $comment
     */
    private $comment = '';

    /**
     * @var string $prefix
     */
    private $prefix = '';

    /**
     * @var array $tables
     */
    private $tables = [];

    /**
     * DataBase constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->setName($name);
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
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEngine(): string
    {
        return $this->engine;
    }

    /**
     * @param string $engine
     */
    public function setEngine(string $engine): void
    {
        $this->engine = $engine;
    }

    /**
     * @return array
     */
    public function getTables(): array
    {
        return $this->tables;
    }

    /**
     * @param array $tables
     */
    public function setTables(array $tables): void
    {
        foreach ($tables as $v){
            if($v instanceof Table){
                throw new RuntimeException('the current table is not instance of Table');
            }
        }
        $this->tables = $tables;
    }

    /**
     * @param Table $table
     */
    public function addTable(Table $table): void
    {
        $this->tables[$table->getTableName()] = $table;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasTable(string $name): bool
    {
        return isset($this->tables[$name])?true:false;
    }

    /**
     * @param string $name
     */
    public function removeTable(string $name): void
    {
        if(!$this->hasTable($name)){
            throw new RuntimeException("table {$name} is not exist");
        }
        unset($this->tables[$name]);
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
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
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     */
    public function setPrefix(string $prefix): void
    {
        $this->prefix = $prefix;
    }
}