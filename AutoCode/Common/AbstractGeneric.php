<?php

namespace AutoCode\Common;

/**
 * 泛型父类
 * Class Generic
 */
abstract class AbstractGeneric implements \Iterator
{
    /**
     * @var int $position
     */
    private $position = 0;

    /**
     * @var array $generic
     */
    private $generic = [];

    /**
     * @var string $type
     */
    private $type = '';

    /**
     * Generic constructor.
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->setType($type);
    }

    /**
     * @param string $type
     */
    private function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return \stdClass
     */
    protected function getElement(): \stdClass
    {
        // 获取一个对象
        $obj     = array_shift($this->generic);
        $objType = gettype($obj);
        if ($objType !== $this->getType()) {
            throw new \RuntimeException("$objType must instance of {$this->getType()}");
        }
        return $obj;
    }

    /**
     * @return mixed
     */
    protected function getCurrentElement()
    {
        // TODO: Implement current() method.
        return $this->generic[$this->position];
    }

    /**
     * @return mixed
     */
    abstract public function pop();

    /**
     * @param $obj
     * @return mixed
     */
    public function push($obj)
    {
        if (!(bool) $obj) {
            return;
        }
        $objType = get_class($obj);
        if ($objType !== $this->getType()) {
            throw new \RuntimeException("$objType must instance of {$this->getType()}");
        }
        $this->generic[] = $obj;
    }

    /**
     * @inheritDoc
     */
    abstract public function current();


    /**
     * @inheritDoc
     */
    public function next(): void
    {
        // TODO: Implement next() method.
        ++$this->position;
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        // TODO: Implement key() method.
        return $this->position;
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        // TODO: Implement valid() method.
        return isset($this->generic[$this->position]);
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        // TODO: Implement rewind() method.
        return $this->position = 0;
    }
}