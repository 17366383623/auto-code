<?php

namespace AutoCode\DataBase\SqlElementObject;

use AutoCode\Auto\Utility\Generic\PropertyGeneric;
use AutoCode\Utility\StringHelper;

/**
 * 数据表对象
 * Class Table
 * @package AutoCode\SqlElementObject
 */
class Table
{
    /**
     * @var PropertyGeneric $column
     */
    private $propertyGeneric;

    /**
     * @var string $engine
     */
    private $engine = 'innodb';

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string
     */
    private $comment = '';

    /**
     * @var string
     */
    private $root_path;

    /**
     * @var string
     */
    private $root_namespace;


    /**
     * Table constructor.
     * @param string $name
     * @param string $rootPath
     * @param string $rootPathNameSpace
     * @param string $comment
     */
    public function __construct(string $name, string $rootPath, string $rootPathNameSpace,string $comment = '')
    {
        $this->setName($name);
        $this->setPropertyGeneric(new PropertyGeneric());
        $comment = $comment?:ucfirst(StringHelper::camel($name));
        $this->setComment($comment);
        if(!is_dir(realpath($rootPath))){
            throw new \RuntimeException("$rootPath is not a valid path");
        }
        $this->setRootPath(realpath($rootPath));
        $this->setRootNamespace($rootPathNameSpace);
    }

    /**
     * @param string $engine
     */
    public function setEngine(string $engine): void
    {
        $this->engine = $engine;
    }

    /**
     * @return string
     */
    public function getEngine(): string
    {
        return $this->engine;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    private function setName(string $name): void
    {
        $this->name = ucfirst($name);
    }

    /**
     * @return PropertyGeneric
     */
    public function getPropertyGeneric(): PropertyGeneric
    {
        return $this->propertyGeneric;
    }

    /**
     * @param PropertyGeneric $propertyGeneric
     */
    public function setPropertyGeneric(PropertyGeneric $propertyGeneric): void
    {
        $this->propertyGeneric = $propertyGeneric;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @return string
     */
    public function getRootPath(): string
    {
        return $this->root_path;
    }

    /**
     * @param string $root_path
     */
    public function setRootPath(string $root_path): void
    {
        if(substr($root_path, 0, -1) === '/'){
            $root_path = substr($root_path, 0, str_len($root_path)-1);
        }
        $this->root_path = $root_path;
    }

    /**
     * @return string
     */
    public function getRootNamespace(): string
    {
        return $this->root_namespace;
    }

    /**
     * @param string $root_namespace
     */
    public function setRootNamespace(string $root_namespace): void
    {
        if(substr($root_namespace, 0, -2) === '\\'){
            $root_path = substr($root_namespace, 0, str_len($root_namespace)-2);
        }
        $this->root_namespace = $root_namespace;
    }
}