<?php


namespace AutoCode;

use http\Exception\RuntimeException;
use Nette\PhpGenerator\Type;

class MethodConfig
{
    /**
     * property auth
     */
    public const PUBLIC = 'public';
    public const PRIVATE = 'private';
    public const PROTECTED = 'protected';

    /**
     * @var string $methodName
     */
    private string $methodName;

    /**
     * @var array $comment
     */
    private ?array $comment = [];

    /**
     * @var bool $static
     */
    private bool $static = FALSE;

    /**
     * @var Type $returnType
     */
    private Type $returnType;

    /**
     * @var bool $returnNullable
     */
    private bool $returnNullable = FALSE;

    /**
     * @var array $params
     */
    private ?array $params = [];

    /**
     * @var string $body
     */
    private string $body;

    /**
     * @param string $methodName
     */
    public function setMethodName(string $methodName): void
    {
        $this->methodName = $methodName;
    }

    /**
     * @return string
     */
    public function getMethodName(): string
    {
        return $this->methodName;
    }

    /**
     * @param array $commentArr
     */
    public function setComment(array $commentArr): void
    {
        $this->comment = $commentArr;
    }

    /**
     * is static
     */
    public function setStatic(): void
    {
        $this->static = TRUE;
    }

    /**
     * @param Type $type
     */
    public function setReturnType(Type $type): void
    {
        $this->returnType = $type;
    }

    /**
     * @return Type
     */
    public function getReturnType(): Type
    {
        return $this->returnType;
    }

    /**
     * return is null
     */
    public function setReturnNullable(): void
    {
        $this->returnNullable = TRUE;
    }

    /**
     * @return bool
     */
    public function getReturnNullable(): bool
    {
        return (bool)$this->returnNullable;
    }

    /**
     * @return bool
     */
    public function getStatic(): bool
    {
        return (bool)$this->static;
    }

    /**
     * @return array
     */
    public function getComment(): array
    {
        return $this->comment;
    }

    /**
     * @param array $paramsArr
     */
    public function setParams(array $paramsArr): void
    {
        foreach ($paramsArr as $v){
            if(!isset($v['param'], $v['type'])){
                throw new RuntimeException('set method params error');
            }
        }
        $this->params = $paramsArr;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }
}