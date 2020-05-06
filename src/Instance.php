<?php


namespace AutoCode;

/**
 * Trait Instance
 * @package AutoCode
 */
trait Instance
{
    /**
     * @var $class
     */
    private static $class = '';

    /**
     * Instance constructor.
     */
    private function __construct()
    {
        self::$class = new self();
    }

    /**
     * @return $this
     */
    public static function getInstance():self
    {
        if(self::$class !== ''){
            return self::$class;
        }
        $class = new self();
        self::$class = $class;
        $methodArr = get_class_methods(__FUNCTION__);
        if(in_array('init', $methodArr, TRUE)){
            self::init();
        }
    }
}