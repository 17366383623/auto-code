<?php


namespace AutoCode\Thinkphp\DateBase;


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

    public function setType(string $type): void
    {
        $this->type = $type;
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