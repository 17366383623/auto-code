<?php


namespace AutoCode\Auto\Thinkphp;

use AutoCode\Auto\Utility\AbstractGenerator;
use AutoCode\Auto\Utility\Generic\MethodGeneric;
use AutoCode\Auto\Utility\Generic\PropertyGeneric;
use AutoCode\DataBase\SqlElementObject\Table;
use AutoCode\Common\StringHelper;

/**
 * 服务生成器
 * Class ServiceGenerator
 * @package AutoCode\Auto\Thinkphp
 */
abstract class ServiceGenerator extends AbstractGenerator
{
    /**
     * ServiceGenerator constructor.
     * @param string $namespace
     * @param string $className
     * @param string $path
     * @param PropertyGeneric $property
     * @param MethodGeneric $method
     * @param string $comment
     */
    public function __construct(string $namespace, string $className, string $path, PropertyGeneric $property, MethodGeneric $method, string $comment = '')
    {
        $className = ucfirst(StringHelper::camel($className));
        $comment = $comment?:$className;
        parent::__construct($namespace, $className, $path, [], $comment);
        $this->run($property, $method);
    }

    /**
     * @param PropertyGeneric $property
     * @param MethodGeneric $method
     */
    private function run(PropertyGeneric $property, MethodGeneric $method): void
    {
        $this->setProperty($property);
        $this->setMethod($method);
        $this->createFile();
    }

    /**
     * 获取目录
     * @param Table $table
     * @return string
     */
    protected function getNamespace(Table $table): string
    {
        $rootNamespace = $table->getRootNamespace();
        $name          = ucfirst(StringHelper::camel($table->getName()));
        $rootNamespace .= "\\Service\\$name";
        return $rootNamespace;
    }

    /**
     * @param Table $table
     * @return string
     */
    protected function getRootPath(Table $table): string
    {
        $rootPath = $table->getRootPath();
        $name     = ucfirst(StringHelper::camel($table->getName()));
        // 创建子集目录
        if (!is_dir($baseDir = $rootPath .= '/Service') && !mkdir($baseDir) && !is_dir($baseDir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $baseDir));
        }
        $rootPath .= "/$name";
        return $rootPath;
    }

    /**
     * 获取驼峰名称
     * @param Table $table
     * @return string
     */
    protected function getName(Table $table): string
    {
        return lcfirst(StringHelper::camel($table->getName()));
    }
}