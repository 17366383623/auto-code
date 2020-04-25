<?php


namespace AutoCode\Thinkphp\BaseModule\Entity;


use AutoCode\AbstractGenerator;
use AutoCode\DateBase\Column;
use AutoCode\DateBase\DataBase;
use AutoCode\DateBase\Table;
use AutoCode\MethodConfig;
use AutoCode\PropertyConfig;
use AutoCode\AccessControlType;
use AutoCode\Utility\FileSystem;
use AutoCode\Utility\StringHelper;
use http\Exception\RuntimeException;
use Nette\PhpGenerator\Parameter;
use Nette\PhpGenerator\Type;

class ModelGenerator extends AbstractGenerator
{
    /**
     * @var array|null
     */
    private ?array $useList = [];

    /**
     * ModelGenerator constructor.
     * @param string $path
     * @param string $namespace
     * @param Table $table
     */
    public function __construct(string $path, string $namespace, Table $table)
    {
        parent::__construct($namespace, $table->getTableName(), $this->getUseList());
        $this->addExtend('think\Model');
        $this->createModelFile($table, $path);
    }

    /**
     * @return array
     */
    protected function getUseList(): array
    {
        return $this->useList;
    }

    /**
     * @param Table $table
     * @param string $path
     */
    protected function createModelFile(Table $table, string $path): void
    {
        // 获取表名
        $tableName = ucfirst($table->getTableName());
        // 创建类备注
        $this->setClassComment([
            $table->getTableName(),
            ' ',
            'Entity: '.StringHelper::snake($table->getTableName())
        ]);
        // 创建元素
        foreach ($table->getColumn() as $col){
            // 创建属性
            $this->createColumn($col);
        }
        // 创建字段类型转换器
        $this->createColumnTypeProperty($table);
        // 设置自动时间戳
        if($autoTimestamp = $table->getAutoWriteTimestamp()){
            $this->setAutoWriteTimestamp($autoTimestamp);
        }
        // 设置只读属性
        if($readonly = $table->getReadonly()){
            $this->setReadonly($readonly);
        }
        // 设置软删除
        if($softDelete = $table->getSoftDelete()){
            $this->setSoftDelete($softDelete);
        }
        FileSystem::createPhpFile($path, $tableName, $this->dump());
    }

    /**
     * @param Table $table
     */
    protected function createColumnTypeProperty(Table $table):void
    {
        $property = new PropertyConfig();
        $property->setComment([
            '数据类型',
            ' ',
            '@var array '.$table->getTableName()
        ]);
        $typeArr = [];
        foreach ($table as $col){
            $typeArr[$col->getColumnName()] =  $col->getPhpType();
        }
        $property->setType(Type::ARRAY);
        $property->setAccessControl(AccessControlType::PUBLIC);
        $property->setPropertyName('type');
        $this->addProperty($property);
    }

    /**
     * set auto timestamp
     * @param string $autoTimestamp
     */
    protected function setAutoWriteTimestamp(string $autoTimestamp): void
    {
        $property = new PropertyConfig();
        $property->setComment([
            'auto timestamp'
        ]);
        $property->setPropertyName('autoWriteTimestamp');
        $property->setAccessControl(AccessControlType::PROTECTED);
        $property->setValue($autoTimestamp);
        $this->addProperty($property);
    }

    /**
     * set readonly
     * @param array $readonly
     */
    protected function setReadonly(array $readonly): void
    {
        $property = new PropertyConfig();
        $property->setComment([
            'set readonly property',
            ' ',
            '@var array'
        ]);
        $property->setPropertyName('readonly');
        $property->setAccessControl(AccessControlType::PROTECTED);
        $property->setValue($readonly);
        $this->addProperty($property);
    }

    /**
     * @param string $softDelete
     */
    protected function setSoftDelete(string $softDelete): void
    {
        $this->addTrait(['traits\model\SoftDelete']);
        $property = new PropertyConfig();
        $property->setComment([
            'set soft_delete',
            ' ',
            '@var string'
        ]);
        $property->setAccessControl(AccessControlType::PROTECTED);
        $property->setPropertyName('deleteTime');
        $property->setValue($softDelete);
        $this->addProperty($property);
    }

    /**
     * @param Column $column
     */
    protected function createColumn(Column $column): void
    {
        $property = new PropertyConfig();
        $property->setPropertyName($column->getColumnName());
        $property->setComment($column->getComment());
        $property->setAccessControl(\AutoCode\AccessControlType::PUBLIC);
        $property->setType($column->getPhpType());
        if($column->getIsNullable()){
            $property->setNullable();
        }
        if($column->getIsNullable()){
            $property->setValue($column->getDefaultValue());
        }
        $this->addProperty($property);
    }
}