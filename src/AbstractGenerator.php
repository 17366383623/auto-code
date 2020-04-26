<?php
namespace AutoCode;

use AutoCode\MethodConfig;
use AutoCode\PropertyConfig;
use http\Exception\RuntimeException;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\Property;

abstract class AbstractGenerator
{
    /**
     * @var ClassType $class
     */
    private ClassType $class;

    /**
     * @var array
     */
    private array $propertyList = [];

    /**
     * @var array|null
     */
    private ?array $methodList;

    /**
     * @var PhpNamespace $namespace
     */
    private PhpNamespace $namespace;

    /**
     * AbstractGenerator constructor.
     * @param string $namespace
     * @param string $className
     * @param array $useList
     */
    public function __construct(string $namespace, string $className, array $useList = [])
    {
        $this->createClass($namespace, $className, $useList);
    }

    /**
     * @return ClassType
     */
    public function getClassType(): ClassType
    {
        return $this->class;
    }

    /**
     * @param array $comment
     */
    public function setClassComment(array $comment): void
    {
        foreach ($comment as $com){
            $this->class->addComment($com);
        }
    }

    /**
     * @param ClassType $class
     */
    public function setClassType(ClassType $class): void
    {
        $this->class = $class;
    }

    /**
     * create class Object
     *
     * @param string $namespace
     * @param string $className
     * @param array|null $useList
     */
    private function createClass(string $namespace, string $className, ?array $useList): void
    {
        $namespaceObj = new \Nette\PhpGenerator\PhpNamespace($namespace);
        $namespaceObj = $this->addUse($namespaceObj, $useList);
        $this->namespace = $namespaceObj;
        $this->class = $namespaceObj->addClass($className);
    }

    /**
     * @param PhpNamespace $namespaceObj
     * @param array $useList
     * @return PhpNamespace
     */
    public function addUse(PhpNamespace $namespaceObj, array $useList): PhpNamespace
    {
        foreach ($useList as $v){
            $namespaceObj->addUse($v);
        }
        return $namespaceObj;
    }

    /**
     * @param string $extend
     */
    public function addExtend(string $extend): void
    {
        $this->class->addExtend($extend);
    }

    /**
     * @param array $extendArr
     */
    public function setExtend(array $extendArr): void
    {
        $this->class->setExtends($extendArr);
    }

    /**
     * @return array
     */
    public function getExtends(): array
    {
        return $this->class->getExtends();
    }

    /**
     * @param string $implement
     */
    public function addImplement(string $implement): void
    {
        $this->class = $this->class->addImplement($implement);
    }

    /**
     * @param array $traitList
     */
    public function addTrait(array $traitList): void
    {
        foreach ($traitList as $v){
            $this->class->addTrait($v);
        }
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
     * @param array $propertyList
     */
    public function setProperty(array $propertyList):void
    {
        $class = $this->class;
        $propertyArr = [];
        foreach ($propertyList as $v)
        {
            if(!$v instanceof PropertyConfig){
                throw new RuntimeException("{$v} : is not a PropertyConfig");
            }
            $name = $v->getPropertyName();
            $propertyObj = new Property($name);
            // 设置值
            $value = $v->getValue();
            $propertyObj->setValue($value);
            // 设置是否静态
            if($v->getStatic()){
                $propertyObj->setStatic();
            }
            // 设置访问级别
            switch ($v->getAccessControl()){
                case 'public':
                    $propertyObj->setPublic();
                    break;
                case 'private':
                    $propertyObj->setPrivate();
                    break;
                case 'protected':
                    $propertyObj->setProtected();
                    break;
                default:
                    throw new RuntimeException("{$v->getAccessControl()} is not a valid access control string");
                    break;
            }
            // 设置是否可空
            if($v->getNullable()){
                $propertyObj->setNullable();
            }
            // 设置类型
            $propertyObj->setType($v->getType());
            // 设置备注
            $comment = $v->getComment();
            foreach ($comment as $com){
                $propertyObj->addComment($com);
            }
            $propertyArr[] = $propertyObj;
        }
        $class->setProperties($propertyArr);
        $this->class = $class;
    }

    /**
     * @param \AutoCode\PropertyConfig $pro
     */
    public function addProperty(PropertyConfig $pro):void
    {
        foreach ($this->propertyList as $v){
            if($v->getPropertyName() === $pro->getPropertyName()){
                throw new RuntimeException("index {$pro->getPropertyName()} is exist");
            }
        }
        $this->propertyList[$pro->getPropertyName()] = $pro;
        $this->setProperty($this->propertyList);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasProperty(string $name): bool
    {
        if(isset($this->propertyList[$name])){
            return true;
        }
        return false;
    }

    /**
     * @param string $name
     */
    public function removeProperty(string $name): void
    {
        if(isset($this->propertyList[$name])){
            unset($this->propertyList[$name]);
            $this->setProperty($this->propertyList);
            return;
        }
        throw new RuntimeException("{$name} is not exist");
    }

    /**
     * @param \AutoCode\MethodConfig $config
     */
    public function addMethod(MethodConfig $config): void
    {
        $this->methodList[$config->getMethodName()] = $config;
        $this->setMethod($this->methodList);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasMethod(string $name): bool
    {
        if(isset($this->methodList[$name])){
            return true;
        }
        return false;
    }

    /**
     * @param string $name
     */
    public function removeMethod(string $name): void
    {
        if(!isset($this->methodList[$name])){
            throw new RuntimeException("{$name} is not exist");
        }
        unset($this->methodList[$name]);
        $this->setMethod($this->methodList);
    }

    /**
     * @param array $methodList
     */
    public function setMethod(array $methodList): void
    {
        $class = $this->class;
        // 设置容器
        $container = [];
        foreach($this->methodList as $v){
            // 获取备注
            $comment = $v->getComment();
            // 获取访问权限
            $accessControl = $v->getAccessControl();
            // 是否为静态
            $static = $v->getStatic();
            // 获取方法名
            $methodName = $v->getMethodName();
            // 获取参数
            $params = $v->getParams();
            // 获取返回值类型
            $returnType = $v->getReturnType();
            // 返回值是否为空
            $returnNullable = $v->getReturnNullable();
            // 获取方法体
            $body = $v->getBody();
            // 设置属性
            $methodObj = new Method($methodName);
            // 设置备注
            foreach ($comment as $com){
                $methodObj->addComment($com);
            }
            // 设置访问权限
            switch ($accessControl){
                case 'public':
                    $methodObj->setPublic();
                    break;
                case 'private':
                    $methodObj->setPrivate();
                    break;
                case 'protected':
                    $methodObj->setProtected();
                    break;
                default:
                    throw new RuntimeException("{$accessControl} must be public|protected|private");
                    break;
            }
            // 设置静态
            if($static){
                $methodObj->setStatic();
            }
            // 设置参数
            $methodObj->setParameters($params);
            // 设置返回值类型
            $methodObj->setReturnType($returnType);
            // 设置返回值是否为空
            if($returnNullable){
                $methodObj->setReturnNullable();
            }
            // 设置方法体
            $methodObj->setBody($body);
            $container[] = $methodObj;
        }
        $class->setMethods($container);
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function dump(): string
    {
        ob_start();
        echo (new \Nette\PhpGenerator\PsrPrinter)->printNamespace($this->namespace);
        $content = ob_get_clean();
        return '<?php'.PHP_EOL.$content;
    }
}