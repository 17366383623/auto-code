<?php
namespace AutoCode\Thinkphp;

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
     * @param \AutoCode\Thinkphp\ControllerConfig|null $config
     */
    public function __construct(string $namespace, string $className, ?ControllerConfig $config)
    {
        parent::__construct($namespace, $className);
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
}