<?php

namespace AutoCode\Auto\Thinkphp\Validate;

use AutoCode\Auto\Utility\Enum\AccessControl;
use AutoCode\Auto\Utility\Enum\PhpType;
use AutoCode\Auto\Utility\Enum\TransformType;
use AutoCode\Auto\Utility\Generic\PropertyGeneric;
use AutoCode\Auto\Utility\Property;
use AutoCode\DataBase\SqlElementObject\Column;
use AutoCode\DataBase\SqlElementObject\Table;
use AutoCode\DataBase\Utility\SqlTypeEnum;

/**
 * 验证器生成
 * Class ValidateGenerator
 * @package AutoCode\Auto\Thinkphp\Validate
 */
class ValidateGenerator extends \AutoCode\Auto\Thinkphp\ValidateGenerator
{
    /**
     * @var array
     */
    private $rule = [];

    /**
     * ValidateGenerator constructor.
     * @param Table $table
     */
    public function __construct(Table $table)
    {
        parent::__construct($this->getNamespace($table), ucfirst($this->getName($table)).'Validate', $this->getRootPath($table), $this->createProperties($table), ucfirst($this->getName($table)).'验证器');
    }

    /**
     * 创建验证属性属性
     * @param Table $table
     * @return PropertyGeneric
     */
    protected function createProperties(Table $table): PropertyGeneric
    {
        // 设置容器
        $propertyGeneric = new PropertyGeneric();
        // 加入rule属性
        $propertyGeneric->push($this->createRule($table));
        // 加入message属性
        $propertyGeneric->push($this->createMessage($table));
        // 加入验证场景
        $propertyGeneric->push($this->createScene());
        return $propertyGeneric;
    }

    /**
     * @param Table $table
     * @return Property
     */
    private function createRule(Table $table): Property
    {
        $rule = [];
        foreach ($table->getPropertyGeneric() as $property) {
            $name = $property->getSqlColumn()->getName();
            $rule[$name] = '';
            // require 验证
            if (!$default = $property->getSqlColumn()->getDefaultValue()) {
                $rule[$name] .= 'require|';
            }
            // 数字 验证
            if (in_array($property->getSqlColumn()->getType(), [SqlTypeEnum::__INTEGER__, SqlTypeEnum::__TINYINT__, SqlTypeEnum::__SMALLINT__], TRUE)) {
                $rule[$name] .= 'number|';
            }
            // 浮点数 验证
            if($property->getSqlColumn()->getType() === SqlTypeEnum::__DECIMAL__) {
                $rule[$name] .= 'float|';
            }
            // 数组验证
            if ($property->getMapType() === TransformType::__ARRAY__) {
                $rule[$name] .= 'array|';
            }
            // 长度验证
            if( $property->getSqlColumn()->getType() === SqlTypeEnum::__VARCHAR__ ) {
                $rule[$name] .= 'max:'.$property->getSqlColumn()->getSize().'|';
            }
            // 移除末尾标记
            if( substr($rule[$name], -1, 1) === '|' ) {
                $rule[$name] = substr($rule[$name], 0, -1);
            }
        }
        $this->rule = $rule;
        $property = new Property(new Column('rule'));
        $property->setType(PhpType::__ARRAY__);
        $property->setAccessControl(AccessControl::__PROTECTED__);
        $property->getSqlColumn()->setComment('验证规则');
        $property->setValue($rule);
        return $property;
    }

    /**
     * 创建提示message
     * @param Table $table
     * @return Property
     */
    private function createMessage(Table $table): Property
    {
        $message = [];
        foreach ($this->rule as $k => $ruleStr) {
            $ruleStr = explode('|', $ruleStr);
            foreach ($ruleStr as $v) {
                $v = explode(':', $v);
                if ($v[0] === 'require') {
                    $message[$k.'.'.$v[0]] = "$k is null";
                } else if ($v[0] === 'number') {
                    $message[$k.'.'.$v[0]] = "$k must be number";
                } else if ($v[0] === 'float') {
                    $message[$k.'.'.$v[0]] = "$k must be float";
                } else if ($v[0] === 'array') {
                    $message[$k.'.'.$v[0]] = "$k must be array";
                } else if ($v[0] === 'max') {
                    $message[$k.'.'.$v[0]] = "$k must less than $v[1]";
                }
            }
        }
        $property = new Property(new Column('message'));
        $property->setType(PhpType::__ARRAY__);
        $property->setAccessControl(AccessControl::__PROTECTED__);
        $property->getSqlColumn()->setComment('验证消息');
        $property->setValue($message);
        return $property;
    }

    /**
     * 创建验证场景
     * @return Property
     */
    private function createScene(): Property
    {
        $property = new Property(new Column('scene'));
        $property->setType(PhpType::__ARRAY__);
        $property->setAccessControl(AccessControl::__PROTECTED__);
        $property->getSqlColumn()->setComment('验证场景');
        $property->setValue([]);
        return $property;
    }
}