<?php
namespace AutoCode;

use AutoCode\MethodConfig;
use AutoCode\PropertyConfig;
use Nette\PhpGenerator\ClassType;

abstract class AbstractGenerator
{
    /**
     * @var ClassType|null $class
     */
    private ?ClassType $class;

    /**
     * AbstractGenerator constructor.
     * @param string $namespace
     * @param string $className
     */
    public function __construct(string $namespace, string $className)
    {
        $this->createClass($namespace, $className);
    }

    /**
     * create class Object
     *
     * @param string $namespace
     * @param string $className
     */
    private function createClass(string $namespace, string $className): void
    {
        $this->class = new Nette\PhpGenerator\PhpNamespace($namespace);
        $this->class = $this->class->addClass($className);
    }

    /**
     * @param array $useList
     */
    public function addUse(array $useList): void
    {
        $class = $this->class;
        foreach ($useList as $v){
            $class->addUse($v);
        }
        $this->class = $class;
    }

    /**
     * @param string $implement
     */
    public function addImplement(string $implement): void
    {
        $this->class = $this->class->addImplement($implement);
    }

    /**
     * set strict mode
     */
    public function setStrict(): void
    {
        $this->class = $this->class->setStrictTypes();
    }

    /**
     * @param array $traitList
     */
    public function addTrait(array $traitList): void
    {
        $class = $this->class;
        foreach ($traitList as $v){
            $class->addTrait($v);
        }
        $this->class = $class;
    }

    /**
     * @param string $name
     * @param $value
     */
    public function addConst(string $name, $value): void
    {
        $this->class = $this->class->addConstant($name, $value);
    }

    /**
     * @param \AutoCode\PropertyConfig $property
     */
    public function addProperty(PropertyConfig $property):void
    {
        $class = $this->class;
        $name = $property->getPropertyName();
        $value = $property->getValue();
        // 设置属性名和值
        $class = $class->addProperty($name, $value);
        // 设置是否静态
        if($property->getStatic()){
            $class = $class->setStatic();
        }
        // 设置是否可空
        if($property->getNullable()){
            $class = $class->setNullable();
        }
        // 设置类型
        $class = $class->setType($property->getType());
        // 设置备注
        $comment = $property->getComment();
        foreach ($comment as $v){
            $class = $class->addComment($v);
        }
        $this->class = $class;
    }

    /**
     * @param \AutoCode\MethodConfig $config
     */
    public function addMethod(MethodConfig $config): void
    {
        $methodName = $config->getMethodName();
        $comment = $config->getComment();
        $params = $config->getParams();
        $body = $config->getBody();
        $this->class = $this->class->addMethod($methodName);
        foreach ($comment as $v){
            $this->class = $this->class->addComment($v);
        }
        $this->class = $this->class->addParameter($params['param'])->setType($params['type']);
        $this->class = $this->class->addBody($body);
    }
}