<?php


namespace FileSystem\Service;

use FileSystem\Model\FileSystem;

/**
 * 删除文件
 * Class DeleteFile
 * @package FileSystem\Service
 */
class DeleteFile
{
    /**
     * 删除文件
     * @param int $id
     * @param bool $del
     * @return bool
     */
    public static function handle(int $id, bool $del = false): bool
    {
        if(!$del){
            return (bool)FileSystem::destroy($id, $del);
        } else {
            // 删除文件
            $file = FileSystem::find($id);
            if(is_file($file->real_path)){
                @unlink($file-real_path);
            }
            // 删除子文件
            if ($file->file_type === 'dir') {
               if (substr($file->logic_path, -1, 1) !== '/') {
                    $file->logic_path .= '/';
               }
               $childrenDir = $file->logic_path.$file->name;
               $queryRes = FileSystem::where('logic_path','like',"$childrenDir%");
               foreach ($queryRes as $childFile) {
                   $realPath = $childFile->real_path;
                   if(is_file($realPath)) {
                       @unlink($realPath);
                   }
                   $childFile->delete(true);
               }
            }
            return (bool)FileSystem::destroy($id, $del);
        }
    }
}