<?php

namespace AutoCode\Auto\Thinkphp\Model;

use AutoCode\Auto\Utility\Enum\AccessControl;
use AutoCode\Auto\Utility\Enum\PhpType;
use AutoCode\Auto\Utility\Enum\TransformType;
use AutoCode\Auto\Utility\Generic\MethodGeneric;
use AutoCode\Auto\Utility\Generic\PropertyGeneric;
use AutoCode\Auto\Utility\Method;
use AutoCode\Auto\Utility\Property;
use AutoCode\DataBase\SqlElementObject\Column;
use AutoCode\DataBase\SqlElementObject\Table;
use AutoCode\Common\StringHelper;
use AutoCode\DataBase\SqlElementObject\DataBase;

/**
 * 模型生成器
 * Class ModelGenerator
 * @package AutoCode\Auto\Thinkphp\Model
 */
class ModelGenerator extends \AutoCode\Auto\Thinkphp\ModelGenerator
{
    /**
     * InsertServiceGenerator constructor.
     * @param Table $table
     * @param DataBase $dataBase
     */
    public function __construct(Table $table, DataBase $dataBase)
    {
        parent::__construct($this->getNamespace($table), ucfirst(StringHelper::camel($table->getName())), $this->getRootPath($table), $this->createProperty($table, $dataBase), $this->createMethod($table), $table->getComment());
    }

    /**
     * 创建写入方法
     * @param Table $table
     * @return MethodGeneric
     */
    private function createMethod(Table $table): MethodGeneric
    {
        $methodContainer = new MethodGeneric();
        $method          = new Method('init');
        $method->setAccessControl(AccessControl::__PROTECTED__);
        $method->isStatic();
        $method->setComment('事件初始化');
        $method->setReturnType(PhpType::__VOID__);
        $content = '';
        $content .= "self::event('before_insert', static function (".'$user'.') {'.PHP_EOL;
        $content .= '  // to do something when before_insert'.PHP_EOL;
        $content .= '});'.PHP_EOL;
        $content .= "self::event('after_insert', static function (".'$user'.') {'.PHP_EOL;
        $content .= '  // to do something when after_insert'.PHP_EOL;
        $content .= '});'.PHP_EOL;
        $content .= "self::event('before_update', static function (".'$user'.') {'.PHP_EOL;
        $content .= '  // to do something when before_update'.PHP_EOL;
        $content .= '});'.PHP_EOL;
        $content .= "self::event('after_update', static function (".'$user'.') {'.PHP_EOL;
        $content .= '  // to do something when after_update'.PHP_EOL;
        $content .= '});'.PHP_EOL;
        $content .= "self::event('before_write', static function (".'$user'.') {'.PHP_EOL;
        $content .= '  // to do something when before_write'.PHP_EOL;
        $content .= '});'.PHP_EOL;
        $content .= "self::event('after_write', static function (".'$user'.') {'.PHP_EOL;
        $content .= '  // to do something when after_write'.PHP_EOL;
        $content .= '});'.PHP_EOL;
        $content .= "self::event('before_delete', static function (".'$user'.') {'.PHP_EOL;
        $content .= '  // to do something when before_delete'.PHP_EOL;
        $content .= '});'.PHP_EOL;
        $content .= "self::event('after_delete', static function (".'$user'.') {'.PHP_EOL;
        $content .= '  // to do something when after_delete'.PHP_EOL;
        $content .= '});';
        $method->setContent($content);
        $methodContainer->push($method);
        return $methodContainer;
    }

    /**
     * @param Table $table
     * @param DataBase $DataBase
     * @return PropertyGeneric
     */
    private function createProperty(Table $table, DataBase $DataBase): PropertyGeneric
    {
        $propertyContainer = new PropertyGeneric();
        $columns           = $table->getPropertyGeneric();
        // 只读字段
        $propertyContainer->push($this->createColumnReadOnly($columns));
        // 软删除
        $propertyContainer->push($this->createColumnSoftDelete($columns));
        // 软删除默认值
        $propertyContainer->push($this->createColumnSoftDeleteDefault($columns));
        // 自动更新时间戳
        $propertyContainer->push($this->createColumnAutoUpdateTimeStamp($columns));
        // 自动创建时间戳
        $propertyContainer->push($this->createColumnAutoCreateTimeStamp($columns));
        // 类型转换
        $propertyContainer->push($this->createColumnTypeTransForm($columns));
        // 创建主键
        $propertyContainer->push($this->createColumnPrimaryKey($columns));
        // 创建字段过滤
        $propertyContainer->push($this->createColumnFieldList($columns));
        // 创建表名
        $propertyContainer->push($this->createColumnTable($table, $DataBase));
        return $propertyContainer;
    }

    /**
     * 只读字段
     * @param PropertyGeneric $columns
     * @return Property
     */
    private function createColumnReadOnly(PropertyGeneric $columns): ?Property
    {
        $readOnly = [];
        foreach ($columns as $column) {
            if ($column->isReadOnly()) {
                $readOnly[] = lcfirst(StringHelper::snake($column->getSqlColumn()->getName()));
            }
        }
        if (!$readOnly) {
            return NULL;
        }
        $property = new Property(new Column('readonly'));
        $property->setType(PhpType::__ARRAY__);
        $property->setAccessControl(AccessControl::__PROTECTED__);
        $property->setValue($readOnly);
        return $property;
    }

    /**
     * 软删除
     * @param PropertyGeneric $columns
     * @return Property
     */
    private function createColumnSoftDelete(PropertyGeneric $columns): ?Property
    {
        $softDelete = '';
        foreach ($columns as $column) {
            if ((bool) ($column->isSoftDelete())) {
                $softDelete = lcfirst(StringHelper::snake($column->getSqlColumn()->getName()));
                break;
            }
        }
        if (!$softDelete) {
            return NULL;
        }
        $property = new Property(new Column('deleteTime'));
        $property->setType(PhpType::__STRING__);
        $property->setAccessControl(AccessControl::__PROTECTED__);
        $property->setValue($softDelete);
        return $property;
    }

    /**
     * 软删除
     * @param PropertyGeneric $columns
     * @return Property
     */
    private function createColumnSoftDeleteDefault(PropertyGeneric $columns): ?Property
    {
        foreach ($columns as $column) {
            if ((bool) ($column->isSoftDelete())) {
                $property = new Property(new Column('defaultSoftDelete'));
                $property->setType($column->getType());
                $property->setAccessControl(AccessControl::__PROTECTED__);
                $property->setValue($column->getSqlColumn()->getDefaultValue());
                return $property;
            }
        }
        return NULL;
    }

    /**
     * 自动修改时间戳
     * @param PropertyGeneric $columns
     * @return Property
     */
    private function createColumnAutoUpdateTimeStamp(PropertyGeneric $columns): ?Property
    {
        $update = '';
        foreach ($columns as $column) {
            if ($column->isUpdate()) {
                $update = lcfirst(StringHelper::snake($column->getSqlColumn()->getName()));
                break;
            }
        }
        if (!$update) {
            return NULL;
        }
        $property = new Property(new Column('updateTime'));
        $property->setType(PhpType::__STRING__);
        $property->setAccessControl(AccessControl::__PROTECTED__);
        $property->setValue($update);
        return $property;
    }

    /**
     * 自动创建时间戳
     * @param PropertyGeneric $columns
     * @return Property
     */
    private function createColumnAutoCreateTimeStamp(PropertyGeneric $columns): ?Property
    {
        $create = '';
        foreach ($columns as $column) {
            if ($column->isCreate()) {
                $create = lcfirst(StringHelper::snake($column->getSqlColumn()->getName()));
                break;
            }
        }
        if (!$create) {
            return NULL;
        }
        $property = new Property(new Column('createTime'));
        $property->setType(PhpType::__STRING__);
        $property->setAccessControl(AccessControl::__PROTECTED__);
        $property->setValue($create);
        return $property;
    }

    /**
     * 数据转换列
     * @param PropertyGeneric $columns
     * @return Property
     */
    private function createColumnTypeTransForm(PropertyGeneric $columns): Property
    {
        $transForm = [];
        foreach ($columns as $column) {
            if ($column->getMapType() !== TransformType::__STRING__) {
                $transForm[$column->getSqlColumn()->getName()] = $column->getMapType();
            }
        }
        if (!(bool)$transForm) {
            return NULL;
        }
        $property = new Property(new Column('type'));
        $property->setType(PhpType::__ARRAY__);
        $property->setAccessControl(AccessControl::__PROTECTED__);
        $property->setValue($transForm);
        return $property;
    }

    /**
     * 创建主键
     * @param PropertyGeneric $columns
     * @return Property
     */
    private function createColumnPrimaryKey(PropertyGeneric $columns): Property
    {
        $pk = '';
        foreach ($columns as $column) {
            if ($column->getSqlColumn()->isPrimary()) {
                $pk = lcfirst(StringHelper::snake($column->getSqlColumn()->getName()));
            }
        }
        if (!$pk) {
            throw new \RuntimeException('pk is null');
        }
        $property = new Property(new Column('pk'));
        $property->setType(PhpType::__STRING__);
        $property->getSqlColumn()->setComment('主键');
        $property->setAccessControl(AccessControl::__PROTECTED__);
        $property->setValue($pk);
        return $property;
    }


    /**
     * 创建数据库字段集
     * @param PropertyGeneric $columns
     * @return Property
     */
    private function createColumnFieldList(PropertyGeneric $columns): Property
    {
        $fieldList = [];
        foreach ($columns as $column) {
            $fieldList[] = lcfirst(StringHelper::snake($column->getSqlColumn()->getName()));
        }
        if (!$fieldList) {
            throw new \RuntimeException('model field is null');
        }
        $property = new Property(new Column('field'));
        $property->setType(PhpType::__ARRAY__);
        $property->setAccessControl(AccessControl::__PROTECTED__);
        $property->setValue($fieldList);
        return $property;
    }

    /**
     * 创建数据表名字段
     * @param Table $table
     * @param DataBase $database
     * @return Property
     */
    private function createColumnTable(Table $table, DataBase $database): Property
    {
        $property = new Property(new Column('table'));
        $property->setType(PhpType::__ARRAY__);
        $property->setAccessControl(AccessControl::__PROTECTED__);
        $prefix = $database->getPrefix();
        $property->setValue($prefix.lcfirst(StringHelper::snake($table->getName())));
        return $property;
    }
}