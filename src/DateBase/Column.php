<?php


namespace AutoCode\DateBase;


use Nette\PhpGenerator\Type;

class Column
{
    /**
     * @var string $columnName
     */
    private string $columnName;

    /**
     * @var string $type
     */
    private string $type;

    /**
     * @var string $phpType
     */
    private string $phpType;

//    /**
//     * @var bool $initType
//     */
//    private bool $serialize = false;

    /**
     * @var int $size
     */
    private int $size = 50;

    /**
     * @var bool $isNullable
     */
    private bool $isNullable = FALSE;

    /**
     * @var array $comment
     */
    private array $comment = [];

    /**
     * @var string $defaultValue
     */
    private string $defaultValue;


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

//    /**
//     * @param bool $serialize
//     */
//    public function setSerialize(bool $serialize): void
//    {
//        $this->serialize = $serialize;
//    }
//
//    /**
//     * @return bool
//     */
//    public function getSerialize(): bool
//    {
//        return $this->serialize;
//    }

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
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment[0]??'';
    }
}