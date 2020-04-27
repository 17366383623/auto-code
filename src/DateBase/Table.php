<?php


namespace AutoCode\DateBase;


use AutoCode\Utility\FileSystem;
use http\Exception\RuntimeException;

class Table
{
    /**
     * @var array $columns
     */
    private array $columns = [];

    /**
     * @var string $tableName
     */
    private string $tableName;

    /**
     * @var string $namespace
     */
    private string $namespace;

    /**
     * @var string $path
     */
    private string $path;

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
     * @var int $cache
     */
    private int $cache = 0;

    /**
     * @var string $eventPath
     */
    private string $eventPath = '';

    /**
     * @var string $eventNamespace
     */
    private string $eventNamespace;

    /**
     * @var array $event
     */
    private array $event = [
        'before_insert',
        'after_insert',
        'before_update',
        'after_update',
        'before_write',
        'after_write',
        'before_delete',
        'after_delete'
    ];

    /**
     * Table constructor.
     * @param string $name
     * @param string $namespace
     * @param string $path
     */
    public function __construct(string $name, string $namespace, string $path)
    {
        $this->setTableName($name);
        $this->setNamespace($namespace);
        $this->setPath($path);
    }

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
     * @return string
     */
    public function getEventPath(): string
    {
        return $this->eventPath;
    }

    /**
     * @param string $eventPath
     */
    public function setEventPath(string $eventPath): void
    {
        if($eventPath === ''){
            $this->eventPath = '';
            return;
        }
        $eventPath = realpath($eventPath);
        if(!is_dir($eventPath))throw new RuntimeException("{$eventPath} is not dir path");
        $this->eventPath = $eventPath;
    }

    /**
     * @return string
     */
    public function getEventNamespace(): string
    {
        return $this->eventNamespace;
    }

    /**
     * @param string $namespace
     */
    public function setEventNamespace(string $namespace): void
    {
        $this->eventNamespace = $namespace;
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     */
    public function setNamespace(string $namespace): void
    {
        if(!$namespace)throw new RuntimeException("{$namespace} is null");
        $this->namespace = $namespace;
    }

    /**
     * @return int
     */
    public function getCache(): int
    {
        return $this->cache;
    }

    /**
     * @param int $cacheTime
     */
    public function setCache(int $cacheTime): void
    {
        $this->cache = $cacheTime;
    }

    /**
     * @param bool $filter
     * @return array
     */
    public function getEvent(): array
    {
        return $this->event;
    }

    /**
     * @param array $event
     */
    public function setEvent(array $event): void
    {
        $this->event = $event;
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
     */
    public function setPath(string $path): void
    {
        $path = realpath($path);
        if(!is_dir($path))throw new RuntimeException("{$path} is not dir path");
        $this->path = $path;
    }

    /**
     * @return array
     */
    public function getColumn(): array
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