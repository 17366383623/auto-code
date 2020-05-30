<?php

namespace FileSystem\Service;

use FileSystem\Model\FileSystem;

/**
 * 保存文件
 * Class SaveFile
 * @package FileSystem\Service
 */
class SaveFile
{
    /**
     * 保存文件
     * @param string $fileName
     * @param string $logicPath
     * @param string $realPath
     * @return int
     */
    public static function handle(string $fileName, string $logicPath, string $realPath): int
    {
        $file = request()->file($fileName);
        if (!is_dir($realPath) && !mkdir($realPath) && !is_dir($realPath)) {
            throw new \RuntimeException("$realPath is not a valid path");
        }
        if ($movedFile = $file->move($realPath)) {
            if($realPath[strlen($realPath) - 1] === '/') {
                $realPath = substr($realPath, 0, -1);
            }
            $realPath       .= '/'.$movedFile->getExtension();
            $uploadFileInfo = $movedFile->getInfo();
            $fileName       = $uploadFileInfo['name'];
            $fileType       = $uploadFileInfo['type'];
            $size           = $uploadFileInfo['size'];
            $saveArr        = [
                'file_name'  => $fileName,
                'file_type'  => $fileType,
                'file_size'  => $size,
                'real_path'  => $realPath,
                'logic_path' => $logicPath,
            ];
            return FileSystem::create($saveArr)->id;
        }
        throw new \RuntimeException('file move error');
    }
}