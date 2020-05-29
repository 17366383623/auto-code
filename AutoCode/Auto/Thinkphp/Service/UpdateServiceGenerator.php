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
 * 更新服务生成器
 * Class UpdateServiceGenerator
 * @package AutoCode\Auto\Thinkphp\Service
 */
class UpdateServiceGenerator extends ServiceGenerator
{
    /**
     * InsertServiceGenerator constructor.
     * @param Table $table
     */
    public function __construct(Table $table)
    {
        parent::__construct($this->getNamespace($table), ucfirst(StringHelper::camel($table->getName())).'UpdateService', $this->getRootPath($table), $this->createProperty($table), $this->createMethod($table), $table->getComment());
    }

    /**
     * 创建写入方法
     * @param Table $table
     * @return MethodGeneric
     */
    private function createMethod(Table $table): MethodGeneric
    {
        $name            = $this->getName($table);
        $methodContainer = new MethodGeneric();
        $method          = new Method('handle');
        $method->setIsStatic();
        $method->setComment('修改数据');
        $method->setReturnType(PhpType::__BOOLEAN__);
        $param = new Parameter("{$name}Arr");
        $param->setType(PhpType::__ARRAY__);
        $paramGeneric = new ParamGeneric();
        $paramGeneric->push($param);
        $method->setParamGeneric($paramGeneric);
        $content = '';
        $content .= 'if (!(bool)$'.$name.'Arr) {'.PHP_EOL;
        $content .= '  throw new \RuntimeException(\'update array is null\');'.PHP_EOL;
        $content .= '}'.PHP_EOL;
        $content .= 'return (bool)\\'.$table->getRootNamespace().'\\Model\\'.ucfirst($this->getName($table)).'::create($'.$name.'Arr);'.PHP_EOL;
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