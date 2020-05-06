<?php


namespace AutoCode;

use http\Exception\RuntimeException;
use Nette\PhpGenerator\Parameter;
use Nette\PhpGenerator\Type;

class MethodConfig
{
    /**
     * @var array $comment
     */
    private $comment = [];

    /**
     * @var string $methodName
     */
    private $methodName;

    /**
     * @var bool $static
     */
    private $static = FALSE;

    /**
     * @var string $accessControl
     */
    private $accessControl = 'public';

    /**
     * @var string $returnType
     */
    private $returnType = '';

    /**
     * @var bool $returnNullable
     */
    private $returnNullable = FALSE;

    /**
     * @var array $params
     */
    private $params = [];

    /**
     * @var string $body
     */
    private $body = '';

    /**
     * MethodConfig constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->setMethodName($name);
    }

    /**
     * @param string $methodName
     */
    public function setMethodName(string $methodName): void
    {
        $this->methodName = $methodName;
    }

    /**
     * @param array $commentArr
     */
    public function setComment(array $commentArr): void
    {
        $this->comment = $commentArr;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @param array $paramsArr
     */
    public function setParams(array $paramsArr): void
    {
        foreach ($paramsArr as $v){
            if(!$v instanceof Parameter){
                throw new RuntimeException("params must be instance of Nette\PhpGenerator\Parameter");
            }
        }
        $this->params = $paramsArr;
    }

    /**
     * @param string $accessControl
     * @throws \Exception
     */
    public function setAccessControl(string $accessControl): void
    {
        if(!in_array($accessControl, [(string)AccessControlType::PUBLIC, (string)AccessControlType::PROTECTED, (string)AccessControlType::PRIVATE])){
            throw new \Exception("{$accessControl} must be public|private|protected");
        }
        $this->accessControl = $accessControl;
    }

    /**
     * is static
     */
    public function setStatic(): void
    {
        $this->static = TRUE;
    }

    /**
     * @param string $type
     */
    public function setReturnType(string $type): void
    {
        $this->returnType = $type;
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
     * @return string
     */
    public function getReturnType(): string
    {
        return $this->returnType;
    }

    /**
     * @return string
     */
    public function getAccessControl(): string
    {
        return $this->accessControl;
    }

    /**
     * @return string
     */
    public function getMethodName(): string
    {
        return $this->methodName;
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
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }
}