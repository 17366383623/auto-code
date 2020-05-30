<?php


namespace FileSystem\Service;


use FileSystem\Model\FileSystem;

class CreateDir
{
    /**
     * @param string $name
     * @param string $logicPath
     * @return int
     */
    public static function handle(string $name, string $logicPath): int
    {
        $saveArr        = [
            'file_name'  => $name,
            'file_type'  => 'dir',
            'file_size'  => '0',
            'real_path'  => '',
            'logic_path' => $logicPath,
        ];
        return FileSystem::create($saveArr)->id;
    }
}