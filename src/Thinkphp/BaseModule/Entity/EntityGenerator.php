<?php

namespace AutoCode\Thinkphp\BaseModule\Entity;

use AutoCode\AbstractGenerator;
use AutoCode\AccessControlType;
use AutoCode\DateBase\Column;
use AutoCode\DateBase\Table;
use AutoCode\MethodConfig;
use AutoCode\PhpFileGenerator;
use AutoCode\PropertyConfig;
use AutoCode\Utility\FileSystem;
use AutoCode\Utility\StringHelper;
use Nette\PhpGenerator\Parameter;

/**
 * Class EntityGenerator
 * @package AutoCode\Thinkphp\BaseModule\Entity
 */
class EntityGenerator extends AbstractGenerator implements PhpFileGenerator
{
    /**
     * @var $table
     */
    private $table;

    /**
     * EntityGenerator constructor.
     * @param Table $table
     */
    public function __construct(Table $table)
    {
        $this->setTable($table);
        parent::__construct($table->getEntityNamespace(), $table->getTableName());
    }

    /**
     * create entity
     */
    public function create(): void
    {
        $table = $this->table;
        if((bool)$table->getEntityPath() && (bool)$table->getEntityNamespace()){
            $this->createEntity($this->getTable());
            return;
        }
        throw new \RuntimeException('entity path or namespace is null');
    }

    /**
     * @param Table $table
     */
    private function createEntity(Table $table): void
    {
        $columns = $table->getColumn();
        foreach ($columns as $col){
            $this->createAttr($col);
            $this->createMethod($col);
        }
        FileSystem::createPhpFile($table->getEntityPath(),lcfirst($table->getTableName()),$this->dump());
    }

    /**
     * @param Column $col
     */
    public function createAttr(Column $col): void
    {
        $property = new PropertyConfig($col->getColumnName());
        $property->setComment([
            'var '.$col->getPhpType(),
        ]);
        $this->addProperty($property);
    }

    /**
     * @param Column $col
     */
    public function createMethod(Column $col): void
    {
        $this->createGetMethod($col);
        $this->createSetMethod($col);
    }


    /**
     * @param Column $col
     */
    public function createGetMethod(Column $col): void
    {
        $method = new MethodConfig('get'.ucfirst(StringHelper::camel($col->getColumnName())));
        $method->setComment([
            'get '.$col->getColumnName(),
            ' ',
            '@return '.$col->getPhpType()
        ]);
        $method->setReturnType($col->getPhpType());
        $body = 'return $this->'.lcfirst($col->getColumnName()).';';
        $method->setBody($body);
        $this->addMethod($method);
    }

    /**
     * @param Column $col
     */
    public function createSetMethod(Column $col): void
    {
        $method = new MethodConfig('set'.ucfirst(StringHelper::camel($col->getColumnName())));
        $method->setComment([
            'set '.$col->getColumnName(),
            ' ',
            '@param '.$col->getPhpType().' '.$col->getColumnName(),
            '@return void'
        ]);
        $method->setReturnType('void');
        $param = new Parameter(lcfirst($col->getColumnName()));
        $param->setType($col->getPhpType());
        $param->setNullable($col->getIsNullable());
        $method->setParams([$param]);
        $body = '$this->'.lcfirst($col->getColumnName()).' = $'.lcfirst($col->getColumnName()).';';
        $method->setBody($body);
        $this->addMethod($method);
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
}