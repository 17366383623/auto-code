<?php


namespace AutoCode\Auto\Utility\Generic;

use AutoCode\Common\AbstractGeneric;
use Nette\PhpGenerator\Parameter;

/**
 * 参数泛型
 * Class ParamGeneric
 * @package AutoCode\Auto\Utility\Generic
 */
class ParamGeneric extends AbstractGeneric
{
    /**
     * ParamGeneric constructor.
     */
    public function __construct()
    {
        parent::__construct(Parameter::class);
    }

    /**
     * @inheritDoc
     */
    public function pop(): Parameter
    {
        // TODO: Implement pop() method.
        return $this->getElement();
    }

    /**
     * @inheritDoc
     */
    public function current(): Parameter
    {
        // TODO: Implement current() method.
        return $this->getCurrentElement();
    }
}