<?php

namespace AutoCode\Auto\Thinkphp\Service;

use AutoCode\Auto\Thinkphp\ServiceGenerator;
use AutoCode\Auto\Utility\Enum\PhpType;
use AutoCode\Auto\Utility\Generic\MethodGeneric;
use AutoCode\Auto\Utility\Generic\ParamGeneric;
use AutoCode\Auto\Utility\Generic\PropertyGeneric;
use AutoCode\Auto\Utility\Method;
use AutoCode\DataBase\SqlElementObject\Table;
use AutoCode\Common\StringHelper;
use Nette\PhpGenerator\Parameter;

/**
 * 新增服务生成器
 * Class InsertServiceGenerator
 * @package AutoCode\Auto\Thinkphp\Service
 */
class InsertServiceGenerator extends ServiceGenerator
{
    /**
     * InsertServiceGenerator constructor.
     * @param Table $table
     */
    public function __construct(Table $table)
    {
        parent::__construct($this->getNamespace($table), ucfirst(StringHelper::camel($table->getName())).'InsertService', $this->getRootPath($table), $this->createProperty($table), $this->createMethod($table), $table->getComment());
    }

    /**
     * 创建写入方法
     * @param Table $table
     * @return MethodGeneric
     */
    private function createMethod(Table $table): MethodGeneric
    {
        $pk = '';
        // 获取主键
        foreach ($table->getPropertyGeneric() as $property) {
            if ($property->getSqlColumn()->isPrimary()) {
                $pk = lcfirst(StringHelper::snake($property->getSqlColumn()->getName()));
                break;
            }
        }
        if (!$pk) {
            throw new \RuntimeException("{$table->getName()}'s pk is null");
        }
        $name            = $this->getName($table);
        $methodContainer = new MethodGeneric();
        $method          = new Method('handle');
        $method->setIsStatic();
        $method->setComment('插入数据');
        $method->setReturnType(PhpType::__INTEGER__);
        // 参数一
        $param = new Parameter("{$name}Arr");
        $param->setType(PhpType::__ARRAY__);
        // 参数二
        $insertField = new Parameter('insertField');
        $insertField->setType(PhpType::__ARRAY__);
        $insertField->setDefaultValue([]);
        $paramGeneric = new ParamGeneric();
        $paramGeneric->push($param);
        $paramGeneric->push($insertField);
        $method->setParamGeneric($paramGeneric);
        $content = '';
        $content .= 'if (!(bool)$'.$name.'Arr) {'.PHP_EOL;
        $content .= '  throw new \RuntimeException(\'insert array is null\');'.PHP_EOL;
        $content .= '}'.PHP_EOL;
        $content .= 'if ((bool)$insertField) {'.PHP_EOL;
        $content .= '  $'.$name.' = \\'.$table->getRootNamespace().'\\Model\\'.ucfirst(StringHelper::camel($table->getName())).'::create($'.$name.'Arr, $insertField);'.PHP_EOL;
        $content .= '} else {'.PHP_EOL;
        $content .= '  $'.$name.' = \\'.$table->getRootNamespace().'\\Model\\'.ucfirst(StringHelper::camel($table->getName())).'::create($'.$name.'Arr);'.PHP_EOL;
        $content .= '}'.PHP_EOL;
        $content .= 'return (int)$'.$name.'->'.$pk.';';
        $method->setContent($content);
        $methodContainer->push($method);
        return $methodContainer;
    }

    /**
     * @param Table $table
     * @return PropertyGeneric
     */
    private function createProperty(Table $table): PropertyGeneric
    {
        return new PropertyGeneric();
    }
}