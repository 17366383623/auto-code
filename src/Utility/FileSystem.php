<?php


namespace AutoCode\Utility;
use AutoCode\Instance;
use http\Exception\RuntimeException;

class FileSystem
{
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
        return (bool)file_put_contents($path.'/'.ucfirst(StringHelper::camel($fileName)), $body);
    }


    /**
     * @param string $path
     * @param $fileName
     * @param $body
     * @return bool
     */
    public static function createPhpFile(string $path, $fileName, $body): bool
    {
        if(strpos($fileName, '.php') !== 0){
            $fileName.='.php';
        }
        return self::createFile($path, $fileName, $body);
    }
}