<?php

namespace AutoCode\Thinkphp\BaseModule;


class ControllerConfig
{
    /**
     * @var string $controller_path
     */
    private string $controller_path;

    /**
     * @var string $namespaceBase
     */
    private string $namespaceBase;

    /**
     * @param string $controllerPath
     */
    public function setControllerPath(string $controllerPath): void
    {
        $this->controller_path = realpath($controllerPath);
    }

    /**
     * @return string
     */
    public function getControllerPath(): string
    {
        return $this->controller_path;
    }

    /**
     * @return string
     */
    public function getNamespaceBase(): string
    {
        return $this->namespaceBase;
    }

    /**
     * @param string $namespaceBase
     */
    public function setNamespaceBase(string $namespaceBase): void
    {
        $this->namespaceBase = $namespaceBase;
    }
}