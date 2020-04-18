<?php


namespace AutoCode\Thinkphp;


class ControllerConfig
{
    /**
     * @var string $controller_path
     */
    private string $controller_path;

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
}