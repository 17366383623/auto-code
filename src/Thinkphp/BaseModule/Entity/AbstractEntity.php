<?php


namespace AutoCode\Thinkphp\BaseModule\Entity;

use AutoCode\Utility\StringHelper;
use think\Validate;

/**
 * Class AbstractEntity
 * @package AutoCode\Thinkphp\BaseModule\Entity
 */
abstract class AbstractEntity
{
    /**
     * @var array $rules
     */
    protected $rules = [];

    /**
     * @var array $message
     */
    protected $message = [];

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function toArray(): array
    {
        // 获取自身全部属性
        $ref = new \ReflectionClass(static::class);
        $properties = $ref->getProperties();
        $arr = [];
        foreach ($properties as $k => $v){
            $arr[$v->getName()] = $v->getValue()??'';
        }
        return $arr;
    }

    /**
     * @param array $objectArray
     * @param bool $check
     * @return $this
     * @throws \ReflectionException
     */
    public static function construct(array $objectArray, bool $check = TRUE): self
    {
        $class = new static();
        $keys = array_keys($objectArray);
        // 获取全部属性
        $ref = new \ReflectionClass($class);
        $properties = $ref->getProperties();
        // 切割数组
        foreach($properties as $object){
            $name = $object->getName();
            $methodName = 'set'.ucfirst(StringHelper::camel($name));
            if(in_array($name, $keys, TRUE)){
                $class->$methodName($objectArray[$name]);
            }
        }
        if($check){
            $class->validate();
        }
        return $class;
    }

    /**
     * validate
     */
    public function validate(): void
    {
        $validate = new Validate($this->rules, $this->message);
        $check = $validate->check($this->toArray());
        if(!$check){
            throw new \RuntimeException($validate->getError());
        }
    }
}