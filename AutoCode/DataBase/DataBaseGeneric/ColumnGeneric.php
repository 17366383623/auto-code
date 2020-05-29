<?php


namespace AutoCode\DataBase\DataBaseGeneric;

use AutoCode\Common\AbstractGeneric;
use AutoCode\DataBase\SqlElementObject\Column;

/**
 * 数据列泛型
 * Class ColumnGeneric
 * @package AutoCode\DataBase\DataBaseGeneric
 */
class ColumnGeneric extends AbstractGeneric
{
    /**
     * ColumnGeneric constructor.
     */
    public function __construct()
    {
        parent::__construct(Column::class);
    }

    /**
     * @inheritDoc
     */
    public function pop(): Column
    {
        // TODO: Implement pop() method.
        return $this->getElement();
    }

    /**
     * @inheritDoc
     */
    public function push($obj): void
    {
        // TODO: Implement push() method.
        $this->insertElement($obj);
    }

    /**
     * @inheritDoc
     */
    public function current(): Column
    {
        // TODO: Implement current() method.
        return $this->getCurrentElement();
    }
}