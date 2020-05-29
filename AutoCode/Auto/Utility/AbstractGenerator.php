<?php

namespace AutoCode\Auto\Utility;

use AutoCode\Auto\Utility\Enum\AccessControl;
use AutoCode\Auto\Utility\Generic\MethodGeneric;
use AutoCode\Auto\Utility\Generic\PropertyGeneric;
use AutoCode\Common\StringHelper;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\Property;

/**
 * 生成器父类
 * Class AbstractGenerator
 * @package AutoCode\Auto\Utility
 */
abstract class AbstractGenerator
{
    /**
     * @var ClassType $class
     */
    private $class;

    /**
     * @var PhpNamespace $namespace
     */
    private $namespace;

    /**
     * @var string
     */
    private $path;

    /**
     * AbstractGenerator constructor.
     * @param string $namespace 命名空间
     * @param string $className 类名
     * @param string $path
     * @param array $useList 使用到的类
     * @param string $comment 类备注
     */
    public function __construct(string $namespace, string $className, string $path, array $useList = [], string $comment = '')
    {
        $this->createClass($namespace, $className, $path, $useList);
        $this->setClassComment($comment, $namespace, $className);
    }

    /**
     * @param string $comment
     * @param string $namespace
     * @param string $className
     */
    protected function setClassComment(string $comment, string $namespace, string $className): void
    {
        $commentArr   = [];
        $commentArr[] = $comment;
        $commentArr[] = 'Class '.$className;
        $commentArr[] = '@package '.$namespace;
        foreach ($commentArr as $com) {
            $this->class->addComment($com);
        }
    }

    /**
     * create class Object
     *
     * @param string $namespace
     * @param string $className
     * @param string $path
     * @param array|null $useList
     */
    protected function createClass(string $namespace, string $className, string $path, array $useList = []): void
    {
        $namespaceObj    = new \Nette\PhpGenerator\PhpNamespace($namespace);
        $namespaceObj    = $this->addUse($namespaceObj, $useList);
        $this->namespace = $namespaceObj;
        $this->class     = $namespaceObj->addClass($className);
        if (!is_dir($path) && !mkdir($path) && !is_dir($path)) {
            throw new \RuntimeException("$path is not a valid path");
        }
        $this->path = realpath($path);
    }

    /**
     * @param PhpNamespace $namespaceObj
     * @param array $useList
     * @return PhpNamespace
     */
    protected function addUse(PhpNamespace $namespaceObj, array $useList): PhpNamespace
    {
        foreach ($useList as $v) {
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
        foreach ($traitList as $v) {
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
     * 设置类属性
     * @param PropertyGeneric $propertyList
     */
    public function setProperty(PropertyGeneric $propertyList): void
    {
        $class       = $this->class;
        $propertyArr = [];
        foreach ($propertyList as $property) {
            $propertyName = StringHelper::camel($property->getSqlColumn()->getName());
            $propertyObj  = new Property($propertyName);
            // 设置值
            $value = $property->getValue();
            $propertyObj->setValue($value);
            // 设置是否静态
            if ($property->isStatic()) {
                $propertyObj->setStatic();
            }
            // 设置访问级别
            switch ($property->getAccessControl()) {
                case AccessControl::__PUBLIC__:
                    $propertyObj->setPublic();
                    break;
                case AccessControl::__PRIVATE__:
                    $propertyObj->setPrivate();
                    break;
                case AccessControl::__PROTECTED__:
                    $propertyObj->setProtected();
                    break;
                default:
                    throw new \RuntimeException("{$property->getAccessControl()} is not a valid access control string");
                    break;
            }
            // 设置类型
            $propertyObj->setType($property->getType());
            // 设置备注
            $comment = $property->getSqlColumn()->getComment();
            $propertyObj->setComment('@var '.$property->getType().' '.$comment);
            $propertyArr[] = $propertyObj;
        }
        $class->setProperties($propertyArr);
        $this->class = $class;
    }


    /**
     * 设置类方法
     * @param MethodGeneric $methodList
     */
    public function setMethod(MethodGeneric $methodList): void
    {
        $class = $this->class;
        // 设置容器
        $container = [];
        foreach ($methodList as $method) {
            // 获取备注
            $comment = $method->getComment();
            // 获取访问权限
            $accessControl = $method->getAccessControl();
            // 是否为静态
            $static = $method->isStatic();
            // 获取方法名
            $methodName = StringHelper::camel($method->getName());
            // 获取参数
            $params = $method->getParamGeneric();
            // 获取返回值类型
            $returnType = $method->getReturnType();
            // 获取方法体
            $body = $method->getContent();
            // 设置属性
            $methodObj = new Method($methodName);
            // 设置备注
            $methodObj->addComment($comment);
            $paramArr = [];
            foreach ($params as $param) {
                $paramArr[] = $param;
                $paramType  = $param->getType();
                $paramName  = $param->getName();
                $methodObj->addComment('@param '.$paramType.' '.$paramName);
            }
            $methodObj->addComment('@return '.$returnType);
            // 设置访问权限
            switch ($accessControl) {
                case AccessControl::__PUBLIC__:
                    $methodObj->setPublic();
                    break;
                case AccessControl::__PRIVATE__:
                    $methodObj->setPrivate();
                    break;
                case AccessControl::__PROTECTED__:
                    $methodObj->setProtected();
                    break;
                default:
                    throw new \RuntimeException("{$accessControl} must be public|protected|private");
                    break;
            }
            // 设置静态
            if ($static) {
                $methodObj->setStatic();
            }
            // 设置参数
            $methodObj->setParameters($paramArr);
            // 设置返回值类型
            $methodObj->setReturnType($returnType);
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

    /**
     * 创建PHP文件
     */
    public function createFile(): bool
    {
        if (!is_dir($this->path) && !mkdir($this->path) && !is_dir($this->path)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $this->real_path));
        }
        return (bool) file_put_contents($this->path.'/'.ucfirst(StringHelper::camel($this->class->getName())).'.php', $this->dump());
    }
}