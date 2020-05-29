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
 * 删除服务生成
 * Class DeleteServiceGenerator
 * @package AutoCode\Auto\Thinkphp\Service
 */
class DeleteServiceGenerator extends ServiceGenerator
{
    /**
     * InsertServiceGenerator constructor.
     * @param Table $table
     */
    public function __construct(Table $table)
    {
        parent::__construct($this->getNamespace($table), ucfirst(StringHelper::camel($table->getName())).'DeleteService', $this->getRootPath($table), $this->createProperty($table), $this->createMethod($table), $table->getComment());
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
        $method->setComment('删除数据');
        $method->setReturnType(PhpType::__BOOLEAN__);
        // 参数一
        $param = new Parameter("{$name}Arr");
        $param->setType(PhpType::__ARRAY__);
        // 参数二
        $paramBool = new Parameter('isDel');
        $paramBool->setType(PhpType::__BOOLEAN__);
        $paramBool->setDefaultValue(false);
        $paramGeneric = new ParamGeneric();
        $paramGeneric->push($param);
        $paramGeneric->push($paramBool);
        $method->setParamGeneric($paramGeneric);
        $content = '';
        $content .= 'if(!(bool)$'.$name.'Arr){'.PHP_EOL;
        $content .= '  throw new \RuntimeException(\'delete array is null\');'.PHP_EOL;
        $content .= '}'.PHP_EOL;
        $content .= 'return (bool)\\'.$table->getRootNamespace().'\\Model\\'.ucfirst($this->getName($table)).'::destroy($'.$name.'Arr, $isDel);'.PHP_EOL;
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