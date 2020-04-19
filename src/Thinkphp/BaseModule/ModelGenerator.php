<?php


namespace AutoCode\Thinkphp\BaseModule;


use AutoCode\AbstractGenerator;

class ModelGenerator extends AbstractGenerator
{
    /**
     * ModelGenerator constructor.
     * @param string $namespace
     * @param string $className
     * @param array|null $useList
     */
    public function __construct(string $namespace, string $className, ?array $useList)
    {
        parent::__construct($namespace, $className, $useList);
    }
}