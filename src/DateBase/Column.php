<?php


namespace AutoCode\DateBase;


use Nette\PhpGenerator\Type;

class Column
{
    /**
     * @var string $columnName
     */
    private $columnName;

    /**
     * @var string $type
     */
    private $type;

    /**
     * @var string $phpType
     */
    private $phpType;

   /**
    * @var bool $primary
    */
   private $primary = false;

    /**
     * @var int $size
     */
    private $size = 50;

    /**
     * @var bool $isNullable
     */
    private $isNullable = FALSE;

    /**
     * @var array $comment
     */
    private $comment = [];

    /**
     * @var string $defaultValue
     */
    private $defaultValue;


    /**
     * Column constructor.
     * @param string $name
     * @param string $phpType
     * @param string $type
     */
    public function __construct(string $name, string $phpType, string $type)
    {
        $this->setColumnName($name);
        $this->setPhpType($phpType);
        $this->setType($type);
    }

    /**
     * @param string $name
     */
    public function setColumnName(string $name): void
    {
        $this->columnName = $name;
    }

    /**
     * @return string
     */
    public function getColumnName(): string
    {
        return $this->columnName;
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
    public function getDefaultValue(): string
    {
        return $this->defaultValue;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return ColumnType
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setPhpType(string $type):void
    {
        $this->phpType = $type;
    }

    /**
     * @return string
     */
    public function getPhpType(): string
    {
        return $this->phpType;
    }

    /**
     * @return bool
     */
    public function isPrimary(): bool
    {
        return $this->primary;
    }

    /**
     * @param bool $primary
     */
    public function setPrimary(bool $primary = TRUE): void
    {
        $this->primary = $primary;
    }

    /**
     * @param bool $isNullable
     */
    public function setIsNullable(bool $isNullable = TRUE): void
    {
        $this->isNullable = $isNullable;
    }

    /**
     * @return bool
     */
    public function getIsNullable(): bool
    {
        return $this->isNullable;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $commentArr = [];
        $commentArr[] = $comment;
        $commentArr[] = ' ';
        $commentArr[] = '@var '.$this->getPhpType();
        $this->comment = $commentArr;
    }

    /**
     * @return array
     */
    public function getComment(): array
    {
        return $this->comment;
    }
}