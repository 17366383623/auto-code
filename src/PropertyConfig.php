<?php


namespace AutoCode;


use Nette\PhpGenerator\Type;

class PropertyConfig
{
    /**
     * @var string $propertyName
     */
    private string $propertyName;

    /**
     * @var string $value
     */
    private string $value;

    /**
     * @var bool $isStatic
     */
    private bool $isStatic = FALSE;

    /**
     * @var bool $nullable
     */
    private bool $nullable = FALSE;

    /**
     * @var Type
     */
    private Type $type;

    /**
     * @var array $comment
     */
    private ?array $comment = [];

    /**
     * @param string $name
     */
    public function setPropertyName(string $name): void
    {
        $this->propertyName = $name;
    }

    /**
     * @return string
     */
    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

    /**
     * @param $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * set property is static
     */
    public function setStatic(): void
    {
        $this->isStatic = TRUE;
    }

    /**
     * @return bool
     */
    public function getStatic(): bool
    {
        return $this->isStatic;
    }

    /**
     * set nullable
     */
    public function setNullable(): void
    {
        $this->nullable = TRUE;
    }

    /**
     * @return bool
     */
    public function getNullable(): bool
    {
        return (bool)$this->nullable;
    }

    /**
     * @param Type $type
     */
    public function setType(Type $type): void
    {
        $this->type = $type;
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @param array $comment
     */
    public function setComment(array $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return array
     */
    public function getComment(): array
    {
        return $this->comment;
    }
}