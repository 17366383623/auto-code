<?php


namespace AutoCode\DateBase;


use http\Exception\RuntimeException;

class DataBase
{
    /**
     * @var string $name
     */
    private string $name;

    /**
     * @var string $path
     */
    private string $path;

    /**
     * @var string $modelNamespace
     */
    private string $modelNamespace;

    /**
     * @var array|null $tables
     */
    private ?array $tables;

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
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @throws \Exception
     */
    public function setPath(string $path): void
    {
        $path = realpath($path);
        if(!is_dir($path)){
            throw new \Exception("{$path} : is not a path");
        }
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getModelNamespace(): string
    {
        return $this->modelNamespace;
    }

    /**
     * @param string $namespace
     */
    public function setModelNamespace(string $namespace): void
    {
        $this->modelNamespace = $namespace;
    }

    /**
     * @return array|null
     */
    public function getTables(): ?array
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
                throw new RuntimeException("the current table is not instance of Table");
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
}