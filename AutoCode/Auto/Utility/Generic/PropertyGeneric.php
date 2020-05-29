<?php

namespace AutoCode\Auto\Utility\Generic;

use AutoCode\Auto\Utility\Property;
use AutoCode\Common\AbstractGeneric;

/**
 * 属性泛型
 * Class PropertyGeneric
 * @package AutoCode\Auto\Utility\Generic
 */
class PropertyGeneric extends AbstractGeneric
{
    /**
     * PropertyGeneric constructor.
     */
    public function __construct()
    {
        parent::__construct(Property::class);
    }

    /**
     * @inheritDoc
     */
    public function pop(): Property
    {
        // TODO: Implement pop() method.
        return $this->getElement();
    }

    /**
     * @inheritDoc
     */
    public function current(): Property
    {
        // TODO: Implement current() method.
        return $this->getCurrentElement();
    }
}