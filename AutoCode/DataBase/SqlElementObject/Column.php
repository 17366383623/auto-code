<?php

namespace AutoCode\DataBase\SqlElementObject;

use AutoCode\DataBase\Utility\SqlTypeEnum;

/**
 * 数据列对象
 * Class Column
 * @package AutoCode\SqlElementObject
 */
class Column
{
    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $type
     */
    private $type = 'varchar';

    /**
     * @var string $size
     */
    private $size = '30';

    /**
     * @var string $defaultValue
     */
    private $defaultValue;

    /**
     * @var bool $isNullable
     */
    private $isNullable = false;

   /**
    * @var bool $isPrimary
    */
   private $isPrimary = false;

    /**
     * @var bool $auto_increment
     */
   private $auto_increment = false;

    /**
     * @var string $comment
     */
    private $comment = '';


    /**
     * Column constructor.
     * @param string $name
     * @param string $type
     * @param string $size
     */
    public function __construct(string $name, string $type = SqlTypeEnum::__VARCHAR__, string $size = '30')
    {
        $this->setName($name);
        $this->setType($type);
        $this->setSize($size);
    }

    /**
     * @return bool
     */
    public function isAutoIncrement(): bool
    {
        return $this->auto_increment;
    }

    /**
     * @param bool $auto_increment
     */
    public function setAutoIncrement(bool $auto_increment): void
    {
        $this->auto_increment = $auto_increment;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return bool
     */
    public function isPrimary(): bool
    {
        return $this->isPrimary;
    }

    /**
     * @param bool $isPrimary
     */
    public function setIsPrimary(bool $isPrimary = TRUE): void
    {
        $this->isPrimary = $isPrimary;
    }

    /**
     * @return string
     */
    public function getDefaultValue(): ?string
    {
        return $this->defaultValue;
    }

    /**
     * @param string $defaultValue
     */
    public function setDefaultValue(string $defaultValue): void
    {
        $this->defaultValue = $defaultValue;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @param string $size
     */
    public function setSize(string $size): void
    {
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function isNullable(): bool
    {
        return $this->isNullable;
    }

    /**
     * @param bool $isNullable
     */
    public function setIsNullable(bool $isNullable): void
    {
        $this->isNullable = $isNullable;
    }
}