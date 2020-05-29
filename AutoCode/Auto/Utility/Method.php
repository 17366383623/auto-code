<?php


namespace AutoCode\Auto\Utility;

use AutoCode\Auto\Utility\Generic\ParamGeneric;

/**
 * 方法实体
 * Class Method
 * @package AutoCode\Auto\Utility\Generic
 */
class Method
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $comment = '';

    /**
     * @var string
     */
    private $accessControl = 'public';

    /**
     * @var bool
     */
    private $isStatic = false;

    /**
     * @var string
     */
    private $returnType = 'void';

    /**
     * @var ParamGeneric
     */
    private $paramGeneric;

    /**
     * @var string
     */
    private $content = '';

    /**
     * Method constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->setName($name);
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
    public function setIsStatic(bool $isStatic = TRUE): void
    {
        $this->isStatic = $isStatic;
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
    public function getAccessControl(): string
    {
        return $this->accessControl;
    }

    /**
     * @param string $name
     */
    private function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return ParamGeneric
     */
    public function getParamGeneric(): ?ParamGeneric
    {
        return $this->paramGeneric;
    }

    /**
     * @param ParamGeneric $paramGeneric
     */
    public function setParamGeneric(ParamGeneric $paramGeneric): void
    {
        $this->paramGeneric = $paramGeneric;
    }

    /**
     * @return string
     */
    public function getReturnType(): string
    {
        return $this->returnType;
    }

    /**
     * @param string $returnType
     */
    public function setReturnType(string $returnType): void
    {
        $this->returnType = $returnType;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
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
}