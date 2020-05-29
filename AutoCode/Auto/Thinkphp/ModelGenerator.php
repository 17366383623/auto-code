<?php

namespace AutoCode\Auto\Thinkphp;

use AutoCode\Auto\Utility\AbstractGenerator;
use AutoCode\Auto\Utility\Generic\MethodGeneric;
use AutoCode\Auto\Utility\Generic\PropertyGeneric;
use AutoCode\Common\StringHelper;
use AutoCode\DataBase\SqlElementObject\Table;

/**
 * tp 模型生成器
 * Class ModelGenerator
 * @package AutoCode\Auto\Thinkphp
 */
abstract class ModelGenerator extends AbstractGenerator
{
    /**
     * ModelGenerator constructor.
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
        $comment   = $comment ?: $className;
        parent::__construct($namespace, $className, $path, [], $comment);
        $this->addExtend('\think\Model');
        $this->addSoftDelete($property);
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
        $rootNamespace .= "\\Model";
        return $rootNamespace;
    }

    /**
     * @param Table $table
     * @return string
     */
    protected function getRootPath(Table $table): string
    {
        $rootPath = $table->getRootPath();
        $rootPath .= '/Model';
        // 创建子集目录
        if (!is_dir($rootPath) && !mkdir($rootPath) && !is_dir($rootPath)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $rootPath));
        }
        return $rootPath;
    }

    /**
     * 软删除模块
     * @param PropertyGeneric $properties
     */
    protected function addSoftDelete(PropertyGeneric $properties): void
    {
        foreach ($properties as $property) {
            if ((bool) $property->isSoftDelete()) {
                $this->addTrait(['\think\model\concern\SoftDelete']);
                break;
            }
        }
    }
}