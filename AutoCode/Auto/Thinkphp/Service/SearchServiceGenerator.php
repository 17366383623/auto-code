<?php


namespace AutoCode\Auto\Thinkphp\Service;

use AutoCode\Auto\Thinkphp\ServiceGenerator;
use AutoCode\Auto\Utility\Enum\PhpType;
use AutoCode\Auto\Utility\Generic\MethodGeneric;
use AutoCode\Auto\Utility\Generic\ParamGeneric;
use AutoCode\Auto\Utility\Generic\PropertyGeneric;
use AutoCode\Auto\Utility\Method;
use AutoCode\Common\StringHelper;
use AutoCode\DataBase\SqlElementObject\Table;
use Nette\PhpGenerator\Parameter;

/**
 * 创建查询服务
 * Class SearchServiceGenerator
 * @package AutoCode\Auto\Thinkphp\Service
 */
class SearchServiceGenerator extends ServiceGenerator
{
    /**
     * InsertServiceGenerator constructor.
     * @param Table $table
     */
    public function __construct(Table $table)
    {
        parent::__construct($this->getNamespace($table), ucfirst(StringHelper::camel($table->getName())).'SearchService', $this->getRootPath($table), $this->createProperty($table), $this->createMethod($table), $table->getComment());
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
        $method->setComment('查询数据');
        $method->setReturnType(PhpType::__ARRAY__);
        // 查询参数一
        $param = new Parameter("{$name}Arr");
        $param->setType(PhpType::__ARRAY__);
        // 查询参数二
        $fieldParam = new Parameter('field');
        $fieldParam->setType(PhpType::__STRING__);
        $fieldParam->setDefaultValue('*');
        // 查询参数二
        $orderParam = new Parameter('order');
        $orderParam->setType(PhpType::__STRING__);
        $orderParam->setDefaultValue('');
        $paramGeneric = new ParamGeneric();
        $paramGeneric->push($param);
        $paramGeneric->push($fieldParam);
        $paramGeneric->push($orderParam);
        $method->setParamGeneric($paramGeneric);
        $content = '$collection = \\'.$table->getRootNamespace().'\\Model\\'.ucfirst($this->getName($table)).'::where($'.$name.'Arr);'.PHP_EOL;
        $content .= 'if ((bool)$order) {'.PHP_EOL;
        $content .= '  $collection->order($order);'.PHP_EOL;
        $content .= '}'.PHP_EOL;
        $content .= '$queryRes = $collection->field($field)->select();'.PHP_EOL;
        $content .= 'return $queryRes->isEmpty() ? [] : $queryRes->toArray();';
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