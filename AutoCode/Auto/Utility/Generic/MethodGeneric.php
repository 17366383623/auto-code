<?php


namespace AutoCode\Auto\Utility\Generic;


use AutoCode\Auto\Utility\Method;
use AutoCode\Common\AbstractGeneric;

/**
 * 方法泛型
 * Class MethodGeneric
 * @package AutoCode\Auto\Utility\Generic
 */
class MethodGeneric extends AbstractGeneric
{
    /**
     * MethodGeneric constructor.
     */
    public function __construct()
    {
        parent::__construct(Method::class);
    }

    /**
     * @inheritDoc
     */
    public function pop(): Method
    {
        // TODO: Implement pop() method.
        return $this->getElement();
    }

    /**
     * @inheritDoc
     */
    public function current(): Method
    {
        // TODO: Implement current() method.
        return $this->getCurrentElement();
    }
}