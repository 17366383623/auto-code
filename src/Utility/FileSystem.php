<?php


namespace AutoCode\Utility;
use AutoCode\Instance;
use http\Exception\RuntimeException;

class FileSystem
{
    use Instance;

    /**
     * init
     */
    private static function init():void
    {
        var_dump('1111');
        ini_set('allow_url_fopen',1);
        ini_set('user_agent', NULL);
        ini_set('default_socket_timeout', '60');
        ini_set('auto_detect_line_endings', '0');
        ini_set('memory_limit', '512');
    }

    /**
     * @param string $path
     * @param string $fileName
     * @param string $body
     * @return bool
     */
    public static function createFile(string $path, string $fileName, string $body): bool
    {
        $real_path = realpath($path);
        if(!is_dir($real_path) && !mkdir($real_path) && !is_dir($real_path)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $real_path));
        }
        if(!is_dir($real_path)){
            throw new RuntimeException("{$real_path} is not a dir path");
        }
        return (bool)file_put_contents($real_path.$fileName, $body);
    }


    /**
     * @param string $path
     * @param $fileName
     * @param $body
     * @return bool
     */
    public static function createPhpFile(string $path, $fileName, $body): bool
    {
        if(substr($fileName, 0, -4) !== '.php'){
            $fileName.='.php';
        }
        return self::createFile($path, $fileName, $body);
    }
}