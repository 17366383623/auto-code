<?php


namespace AutoCode\Utility;

/**
 * Class StringHelper
 * @package AutoCode\Utility
 */
class StringHelper
{
    /**
     * 检查字符串中是否包含另一字符串
     * @param string       $haystack 被检查的字符串
     * @param string|array $needles  需要包含的字符串
     * @param bool         $strict   为true 则检查时区分大小写
     * @author : evalor <master@evalor.cn>
     * @return bool
     */
    public static function contains($haystack, $needles, $strict = true): bool
    {
        // 不区分大小写的情况下 全部转为小写
        if (!$strict) {
            $haystack = mb_strtolower($haystack);
        }
        // 支持以数组方式传入 needles 检查多个字符串
        foreach ((array)$needles as $needle) {
            if (!$strict) {
                $needle = mb_strtolower($needle);
            }
            if ($needle !== '' && mb_strpos($haystack, $needle) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * 检查字符串是否以某个字符串开头
     * @param string $haystack 被检查的字符串
     * @param string $needles  需要包含的字符串
     * @param bool   $strict   为true 则检查时区分大小写
     * @author : evalor <master@evalor.cn>
     * @return bool
     */
    public static function startsWith($haystack, $needles, $strict = true): bool
    {
        // 不区分大小写的情况下 全部转为小写
        if (!$strict) {
            $haystack = mb_strtolower($haystack);
        }
        // 支持以数组方式传入 needles 检查多个字符串
        foreach ((array)$needles as $needle) {
            if (!$strict) {
                $needle = mb_strtolower($needle);
            }
            if ($needle !== '' && mb_strpos($haystack, $needle) === 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * 检查字符串是否以某个字符串结尾
     * @param string $haystack 被检查的字符串
     * @param string $needles  需要包含的字符串
     * @param bool   $strict   为true 则检查时区分大小写
     * @author : evalor <master@evalor.cn>
     * @return bool
     */
    public static function endsWith($haystack, $needles, $strict = true): bool
    {
        // 不区分大小写的情况下 全部转为小写
        if (!$strict) $haystack = mb_strtolower($haystack);

        // 支持以数组方式传入 needles 检查多个字符串
        foreach ((array)$needles as $needle) {
            if (!$strict) {
                $needle = mb_strtolower($needle);
            }
            if ((string)$needle === mb_substr($haystack, mb_strlen($needle))) {
                return true;
            }
        }
        return false;
    }

    /**
     * 驼峰转下划线
     * @param string $value     待处理字符串
     * @param string $delimiter 分隔符
     * @author : evalor <master@evalor.cn>
     * @return null|string|string[]
     */
    public static function snake($value, $delimiter = '_')
    {
        if (!ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', $value);
            $value = mb_strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1' . $delimiter, $value));
        }
        return $value;
    }

    /**
     * 下划线转驼峰 (首字母小写)
     * @param string $value 待处理字符串
     * @author : evalor <master@evalor.cn>
     * @return string
     */
    public static function camel($value): string
    {
        return lcfirst(static::studly($value));
    }

    /**
     * 下划线转驼峰 (首字母大写)
     * @param string $value 待处理字符串
     * @author : evalor <master@evalor.cn>
     * @return mixed
     */
    public static function studly($value): string
    {
        $value = ucwords(str_replace([ '-', '_' ], ' ', $value));
        return str_replace(' ', '', $value);
    }
}