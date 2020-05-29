<?php


namespace AutoCode\Auto\Utility;

use AutoCode\DataBase\SqlElementObject\Column;

/**
 * 属性实体
 * Class Property
 * @package AutoCode\Auto\Utility
 */
class Property
{
    /**
     * @var Column 数据库列对象
     */
    private $sqlColumn;

    /**
     * @var string php类型
     */
    private $type = 'string';

    /**
     * @var string 转换类型
     */
    private $mapType = 'string';

    /**
     * @var string 访问级别
     */
    private $accessControl = 'public';

    /**
     * @var bool 是否为静态属性
     */
    private $isStatic = FALSE;

    /**
     * @var mixed 默认值
     */
    private $value = '';

    /**
     * @var string 是否为软删除字段
     */
    private $isSoftDelete = '';

    /**
     * @var bool 是否为只读字段
     */
    private $readOnly = FALSE;

    /**
     * @var bool
     */
    private $update = FALSE;

    /**
     * @var bool
     */
    private $create = FALSE;

    /**
     * Property constructor.
     * @param Column $column
     */
    public function __construct(Column $column)
    {
        $this->setSqlColumn($column);
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
     * @return string
     */
    public function getAccessControl(): string
    {
        return $this->accessControl;
    }

    /**
     * @param string $accessControl
     */
    public function setAccessControl(string $accessControl): void
    {
        $this->accessControl = $accessControl;
    }

    /**
     * @return string
     */
    public function getMapType(): string
    {
        return $this->mapType;
    }

    /**
     * @param string $mapType
     */
    public function setMapType(string $mapType): void
    {
        $this->mapType = $mapType;
    }

    /**
     * @return Column
     */
    public function getSqlColumn(): Column
    {
        return $this->sqlColumn;
    }

    /**
     * @param Column $sqlColumn
     */
    private function setSqlColumn(Column $sqlColumn): void
    {
        $this->sqlColumn = $sqlColumn;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function isReadOnly(): bool
    {
        return $this->readOnly;
    }

    /**
     * @param bool $readOnly
     */
    public function setReadOnly(bool $readOnly = true): void
    {
        $this->readOnly = $readOnly;
    }

    /**
     * @return string
     */
    public function isSoftDelete(): string
    {
        return $this->isSoftDelete;
    }

    /**
     * @param string $isSoftDelete
     */
    public function setIsSoftDelete(string $isSoftDelete = ''): void
    {
        $this->isSoftDelete = $isSoftDelete;
    }

    /**
     * @return bool
     */
    public function isStatic(): bool
    {
        return $this->isStatic;
    }

    /**
     * @param bool $isStatic
     */
    public function setIsStatic(bool $isStatic = true): void
    {
        $this->isStatic = $isStatic;
    }

    /**
     * @return bool
     */
    public function isUpdate(): bool
    {
        return $this->update;
    }

    /**
     * @param bool $update
     */
    public function setUpdate(bool $update = TRUE): void
    {
        $this->update = $update;
    }

    /**
     * @return bool
     */
    public function isCreate(): bool
    {
        return $this->create;
    }

    /**
     * @param bool $create
     */
    public function setCreate(bool $create = TRUE): void
    {
        $this->create = $create;
    }
}