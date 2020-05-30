<?php


namespace FileSystem\Service;

use FileSystem\Model\FileSystem;

/**
 * 文件浏览器
 * Class FinderFile
 * @package FileSystem\Service
 */
class FinderFile
{
    /**
     * 浏览逻辑目录文件
     * @param string $logicPath
     * @return array
     */
    public static function handle(string $logicPath): array
    {
        $query = FileSystem::where(['logic_path' => $logicPath])->select();
        return $query->isEmpty ? [] : $query->toArray();
    }
}