<?php


namespace AutoCode\Auto\Thinkphp;


use AutoCode\Auto\Utility\AbstractGenerator;
use AutoCode\Auto\Utility\Generic\PropertyGeneric;
use AutoCode\Common\StringHelper;
use AutoCode\DataBase\SqlElementObject\Table;

/**
 * 验证器生成
 * Class ValidateGenerator
 * @package AutoCode\Auto\Thinkphp
 */
abstract class ValidateGenerator extends AbstractGenerator
{
    /**
     * ValidateGenerator constructor.
     * @param string $namespace
     * @param string $className
     * @param string $path
     * @param PropertyGeneric $property
     * @param string $comment
     */
    public function __construct(string $namespace, string $className, string $path, PropertyGeneric $property, string $comment = '')
    {
        parent::__construct($namespace, $className, $path, [], $comment?:$className);
        $this->addExtend('\think\Validate');
        $this->run($property);
    }

    /**
     *
     * @param PropertyGeneric $properties
     */
    private function run(PropertyGeneric $properties): void
    {
        $this->setProperty($properties);
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
        $rootNamespace .= "\\Validate";
        return $rootNamespace;
    }

    /**
     * @param Table $table
     * @return string
     */
    protected function getRootPath(Table $table): string
    {
        $rootPath = $table->getRootPath();
        $rootPath .= '/Validate';
        // 创建子集目录
        if (!is_dir($rootPath) && !mkdir($rootPath) && !is_dir($rootPath)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $rootPath));
        }
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