<?php


namespace AutoCode\DateBase;


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
     * @var string $initType
     */
    private string $initType = 'string';

    /**
     * @var int $size
     */
    private int $size;

    /**
     * @var bool $isNullable
     */
    private bool $isNullable;

    /**
     * @var string $comment
     */
    private string $comment;

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
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setInitType(string $type): void
    {
        $this->initType = $type;
    }

    /**
     * @return string
     */
    public function getInitType(): string
    {
        return $this->initType;
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
        return $this->comment;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }
}