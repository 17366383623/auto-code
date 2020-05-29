<?php
namespace AutoCode\DataBase\DataBaseGeneric;

use AutoCode\Common\AbstractGeneric;
use AutoCode\DataBase\SqlElementObject\Table;

/**
 * 数据表泛型
 * Class TableGeneric
 * @package AutoCode\DataBase\DataBaseGeneric
 */
class TableGeneric extends AbstractGeneric
{
    /**
     * TableGeneric constructor.
     */
    public function __construct()
    {
        parent::__construct(Table::class);
    }

    /**
     * @inheritDoc
     */
    public function pop(): Table
    {
        // TODO: Implement pop() method.
        return $this->getElement();
    }

    /**
     * @inheritDoc
     */
    public function current(): Table
    {
        // TODO: Implement current() method.
        return $this->getCurrentElement();
    }
}