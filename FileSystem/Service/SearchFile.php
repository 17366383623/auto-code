<?php


namespace FileSystem\Service;

use FileSystem\Model\FileSystem;

/**
 * 查询文件
 * Class SearchFile
 * @package FileSystem\Service
 */
class SearchFile
{
    /**
     * 查询文件
     * @param string $name
     * @return array
     */
    public static function handle(string $name): array
    {
        $searchFile = FileSystem::where('file_name', 'like', "%$name%")->select();
        return $searchFile->isEmpty ? [] : $searchFile->toArray();
    }
}