<?php


namespace AutoCode\Thinkphp\BaseModule;


use AutoCode\AbstractGenerator;
use AutoCode\DateBase\Column;
use AutoCode\DateBase\DataBase;
use AutoCode\DateBase\Table;
use http\Exception\RuntimeException;

class ModelGenerator extends AbstractGenerator
{
    /**
     * @var array|null
     */
    private ?array $useList = [ 'think\\Model' ];

    /**
     * ModelGenerator constructor.
     * @param string $namespace
     * @param string $className
     */
    public function __construct(string $namespace, string $className)
    {
        parent::__construct($namespace, $className, $this->getUseList());
        $this->addExtend('Model');
    }

    /**
     * @return array
     */
    public function getUseList(): array
    {
        return $this->useList;
    }

    /**
     * @param DataBase $dataBase
     */
    public function createBase(DataBase $dataBase): void
    {
        $tables = $dataBase->getTables();
        foreach ($tables as $table){
            if(!$table instanceof Table){
                throw new RuntimeException("the current table is not instance of Table");
            }
            $this->createModelFile($table);
        }
    }

    /**
     * @param Table $table
     */
    public function createModelFile(Table $table): void
    {
        // 获取表名
        $tableName = lcfirst($table->getTableName());
        // 创建属性

    }

    /**
     * @param Column $column
     */
    public function createColumn(Column $column): void
    {
        // 获取列名
        $columnName = $column->getColumnName();
        // 获取列大小
        $columnSize = $column->getSize();
        // 获取列数据类型
        $type = $column->getType();
        // 获取存入数据类型
        $initType = $column->getInitType();
        // 获取是否为空
        $isNullable = $column->getIsNullable();
        // 获取备注
        $comment = $column->getComment();
    }

    /**
     * 创建获取器
     * @param Column $column
     */
    public function createOutput(Column $column): void
    {

    }

    /**
     * 创建修改器
     * @param Column $column
     */
    public function createInput(Column $column): void
    {

    }
}