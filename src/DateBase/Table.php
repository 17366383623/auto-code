<?php


namespace AutoCode\DateBase;


use AutoCode\PhpType;
use AutoCode\Utility\FileSystem;
use http\Exception\RuntimeException;

class Table
{
    /**
     * @var array $columns
     */
    private $columns = [];

    /**
     * @var string $tableName
     */
    private $tableName;

    /**
     * @var string $comment
     */
    private $comment = '';

    /**
     * @var string $namespace
     */
    private $namespace;

    /**
     * @var string $path
     */
    private $path;

    /**
     * @var string $autoWriteTimestamp
     */
    private $autoWriteTimestamp = '';

    /**
     * @var array $readonly
     */
    private $readonly = [];

    /**
     * @var string $softDelete
     */
    private $softDelete = '';

    /**
     * @var int $cache
     */
    private $cache = 0;

    /**
     * @var string $eventPath
     */
    private $eventPath = '';

    /**
     * @var string $eventNamespace
     */
    private $eventNamespace = '';

    /**
     * @var string
     */
    private $serviceNamespace = '';

    /**
     * @var string
     */
    private $servicePath = '';

    /**
     * @var string $entityNamespace
     */
    private $entityNamespace = '';

    /**
     * @var string $entityPath
     */
    private $entityPath = '';

    /**
     * @var array $event
     */
    private $event = [
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
     */
    public function __construct(string $name)
    {
        $this->setTableName($name);
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
        if(!is_dir($eventPath)) {
            throw new RuntimeException("{$eventPath} is not dir path");
        }
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
        if(!$namespace) {
            throw new RuntimeException("{$namespace} is null");
        }
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
     * @return array
     */
    public function getEvent(): array
    {
        return $this->event;
    }

    /**
     * @param array $event
     * @return void
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
                throw new RuntimeException('the current column is not instance of Column');
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

    /**
     * @param string $service_namespace
     */
    public function setServiceNamespace(string $service_namespace): void
    {
        $this->serviceNamespace = $service_namespace;
    }

    /**
     * @return string
     */
    public function getServiceNamespace(): string
    {
        return $this->serviceNamespace;
    }

    /**
     * @return string
     */
    public function getServicePath(): string
    {
        return realpath($this->servicePath);
    }

    /**
     * @param string $path
     */
    public function setServicePath(string $path): void
    {
        $path = realpath($path);
        if(!is_dir($path)){
            throw new RuntimeException("{$path} is not dir");
        }
        $this->servicePath = $path;
    }

    /**
     * @param string $entityNamespace
     */
    public function setEntityNamespace(string $entityNamespace): void
    {
        $this->entityNamespace = $entityNamespace;
    }

    /**
     * @return string
     */
    public function getEntityNamespace(): string
    {
        return $this->entityNamespace;
    }

    /**
     * @param string $entityPath
     */
    public function setEntityPath(string $entityPath): void
    {
        $this->entityPath = $entityPath;
    }

    /**
     * @return string
     */
    public function getEntityPath(): string
    {
        return $this->entityPath;
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
}