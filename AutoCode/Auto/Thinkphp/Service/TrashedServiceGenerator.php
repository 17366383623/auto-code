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
 * 查询垃圾
 * Class TrashedServiceGenerator
 * @package AutoCode\Auto\Thinkphp\Service
 */
class TrashedServiceGenerator extends ServiceGenerator
{
    /**
     * InsertServiceGenerator constructor.
     * @param Table $table
     */
    public function __construct(Table $table)
    {
        if ($this->isSoftDelete($table)) {
            parent::__construct($this->getNamespace($table), ucfirst(StringHelper::camel($table->getName())).'TrashedService', $this->getRootPath($table), $this->createProperty($table), $this->createMethod($table), $table->getComment());
        }
    }

    /**
     * 创建写入方法
     * @param Table $table
     * @return MethodGeneric
     */
    private function createMethod(Table $table): MethodGeneric
    {
        $methodContainer = new MethodGeneric();
        $method          = new Method('handle');
        $method->setIsStatic();
        $method->setComment('查询垃圾数据');
        $method->setReturnType(PhpType::__ARRAY__);
        $param = new Parameter('whereArr');
        $param->setType(PhpType::__ARRAY__);
        $param->setDefaultValue([]);
        $paramGeneric = new ParamGeneric();
        $paramGeneric->push($param);
        $method->setParamGeneric($paramGeneric);
        $content = 'return \\'.$table->getRootNamespace().'\\Model\\'.ucfirst($this->getName($table)).'::onlyTrashed(true)->select($whereArr);'.PHP_EOL;
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

    /**
     * 查询是否存在软删除字段
     * @param Table $table
     * @return bool
     */
    private function isSoftDelete(Table $table): bool
    {
        foreach ($table->getPropertyGeneric() as $property) {
            if ($property->isSoftDelete()) {
                return true;
            }
        }
        return false;
    }
}