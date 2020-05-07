<?php


namespace AutoCode\Thinkphp\BaseModule\Service;


use AutoCode\PhpFileGenerator;

interface UtilityServiceGenerator extends PhpFileGenerator
{
    /**
     * init database table and more
     */
    public function init(): void;

    /**
     * @return string
     */
    public function getServiceName():string;
}