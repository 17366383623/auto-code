<?php


namespace AutoCode;


use AutoCode\DateBase\ColumnType;
use http\Exception\RuntimeException;
use Nette\PhpGenerator\Type;

class PropertyConfig
{
    /**
     * @var string $accessControl
     */
    private string $accessControl;

    /**
     * @var string $propertyName
     */
    private string $propertyName;

    /**
     * @var mixed $value
     */
    private $value;

    /**
     * @var bool $isStatic
     */
    private bool $isStatic = FALSE;

    /**
     * @var bool $nullable
     */
    private bool $nullable = FALSE;

    /**
     * @var string
     */
    private string $type;

    /**
     * @var array $comment
     */
    private ?array $comment = [];

    /**
     * @param string $control
     */
    public function setAccessControl(string $control): void
    {
        if(!in_array($control, [AccessControlType::PROTECTED, AccessControlType::PUBLIC, AccessControlType::PRIVATE])){
            throw new RuntimeException("access control is error : {$control}");
        }
        $this->accessControl = $control;
    }

    /**
     * @return string
     */
    public function getAccessControl(): string
    {
        return $this->accessControl;
    }

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
    public function getValue()
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
        return $this->type??'';
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