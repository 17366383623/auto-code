<?php


namespace AutoCode\FileSystem;
use AutoCode\Instance;
use http\Exception\RuntimeException;

class FileSystem
{
    use Instance;

    /**
     * init
     */
    private function init():void
    {
        ini_set('allow_url_fopen',1);
        ini_set('user_agent', NULL);
        ini_set('default_socket_timeout', '60');
        ini_set('auto_detect_line_endings', '0');
    }

    /**
     * @param string $path
     * @param string $fileName
     * @param string $body
     * @return bool
     */
    public function createFile(string $path, string $fileName, string $body): bool
    {
        $real_path = realpath($path);
        if(!is_dir($real_path)){
            @mkdir($real_path);
        }
        if(!is_dir($real_path)){
            throw new RuntimeException("{$real_path} is not a dir path");
        }
        return (bool)file_put_contents($real_path.$fileName, $body);
    }
}