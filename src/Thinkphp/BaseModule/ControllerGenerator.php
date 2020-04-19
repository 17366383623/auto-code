<?php
namespace AutoCode\Thinkphp\BaseModule;

use AutoCode\AbstractGenerator;
use AutoCode\Thinkphp\ControllerConfig;

/**
 * Class ControllerGenerator
 * @package AutoCode\Thinkphp
 */
class ControllerGenerator extends AbstractGenerator
{
    /**
     * @var \AutoCode\Thinkphp\ControllerConfig|null $controller_path
     */
    private ?ControllerConfig $controller_config;

    /**
     * ControllerGenerator constructor.
     * @param string $namespace
     * @param string $className
     * @param array|null $useList
     * @param \AutoCode\Thinkphp\ControllerConfig|null $config
     */
    public function __construct(string $namespace, string $className, ?array $useList, ControllerConfig $config = NULL)
    {
        parent::__construct($namespace, $className, $useList);
        if($config){
            $this->setControllerConfig($config);
        }
    }

    /**
     * @param \AutoCode\Thinkphp\ControllerConfig $config
     */
    public function setControllerConfig(ControllerConfig $config):void
    {
        $this->controller_config = $config;
    }

    /**
     * @return \AutoCode\Thinkphp\ControllerConfig|null
     */
    public function getControllerConfig():?ControllerConfig
    {
        return $this->controller_config;
    }

    public function controllerMethodGenerator()
    {

    }
}
