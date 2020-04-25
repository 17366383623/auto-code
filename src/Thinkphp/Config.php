<?php


namespace AutoCode\Thinkphp;


use http\Exception\RuntimeException;

class Config
{
    /**
     * @var array $config
     */
    private static array $config = [

    ];

    /**
     * @param string $name
     * @return string
     */
    public static function get(string $name): string
    {
        if(self::has($name)){
            return self::$config[$name];
        }
        throw new RuntimeException("{$name} is not exist");
    }

    /**
     * @param string $name
     * @return bool
     */
    public static function has(string $name): bool
    {
        if(isset(self::$config[$name])){
            return true;
        }
        return false;
    }
}