<?php

namespace AutoCode\Auto\Utility\Enum;

/**
 * php数据库转换类型枚举
 * Class PhpType
 * @package AutoCode\Auto\Utility\Enum
 */
class TransformType
{
    public const __STRING__ = 'string';

    public const  __INTEGER__ = 'int';

    public const  __FLOAT__ = 'float';

    public const __BOOLEAN__ = 'bool';

    public const __ARRAY__ = 'array';

    public const __OBJECT__ = 'object';

    public const __SERIALIZE__ = 'serialize';

    public const __JSON__ = 'json';

    public const __TIMESTAMPYMD__ = 'timestamp:Y-m-d';

    public const __TIMESTAMPYMDHIS__ = 'timestamp:Y-m-d H:i:s';
}