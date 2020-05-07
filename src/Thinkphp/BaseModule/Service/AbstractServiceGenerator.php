<?php


namespace AutoCode\Thinkphp\BaseModule\Service;


use AutoCode\AbstractGenerator;
use AutoCode\DateBase\Table;
use AutoCode\PhpFileGenerator;
use AutoCode\Utility\FileSystem;
use AutoCode\Utility\StringHelper;

abstract class AbstractServiceGenerator extends AbstractGenerator implements PhpFileGenerator
{
    /**
     * @var array $useList
     */
    private $useList = [];

    /**
     * @var Table
     */
    private $table;

    /**
     * AbstractServiceGenerator constructor.
     * @param Table $table
     */
    public function __construct(Table $table)
    {
        $this->valid($table);
        $this->setTable($table);
        parent::__construct($table->getServiceNamespace(), ucfirst(StringHelper::camel($table->getTableName()).'BaseService'), $this->useList);
    }

    /**
     * @param Table $table
     */
    public function setTable(Table $table): void
    {
        $this->table = $table;
    }

    /**
     * @return Table
     */
    public function getTable(): Table
    {
        return $this->table;
    }

    /**
     * create service
     */
    public function create(): void
    {
        $this->createInsertMethod();
        $this->createDeleteMethod();
        $this->createEditMethod();
        $this->createTrashedMethod();
        $this->createRecoverMethod();
        FileSystem::createPhpFile($this->table->getServicePath(), ucfirst($this->table->getTableName()).'BaseService', $this->dump());
    }

    /**
     * valid params
     * @param Table $table
     */
    protected function valid(Table $table): void
    {
        if(!$table->getServiceNamespace()){
            throw new \RuntimeException('Service namespace is null');
        }
        if(!$table->getTableName()){
            throw new \RuntimeException('table name is null');
        }
    }

    /**
     * insert method
     */
    abstract protected function createInsertMethod(): void;

    /**
     * delete method
     */
    abstract protected function createDeleteMethod(): void;

    /**
     * edit method
     */
    abstract protected function createEditMethod(): void;

    /**
     * trashed method
     */
    abstract protected function createTrashedMethod(): void;

    /**
     * create recover from trashed method
     */
    abstract protected function createRecoverMethod():void;
}