<?php


namespace FileSystem\Service;

use FileSystem\Model\FileSystem;
use think\Db;

/**
 * 移动文件
 * Class MoveFile
 * @package FileSystem\Service
 */
class MoveFile
{
    /**
     * @param int $id
     * @param string $logicPath
     * @return bool
     */
    public static function handle(int $id, string $logicPath): bool
    {
        $file = FileSystem::get($id);
        if($file->file_type !== 'dir') {
            $file->logic_path = $logicPath;
            return (bool)$file->save();
        } else {
            Db::startTrans();
            try {
                if (substr($logicPath, -1, 1) !== '/') {
                    $logicPath .= '/';
                }
                // 获取原逻辑地址
                $oldLogicPath = $file->logic_path;
                $oldLogicPath .= $file->name;
                $updateArr = FileSystem::where('logic_path', 'like', "$logicPath%")->cursor();
                foreach ($updateArr as $f) {
                    $f->logic_path = preg_replace("/.*{$file->name}\//", $logicPath, $oldLogicPath);
                    $f->save();
                }
                $file->logic_path = $logicPath;
                $file->save();
                Db::commit();
            }catch (\Throwable $e) {
                Db::rollback();
                throw new \RuntimeException($e->getMessage());
            }
        }
    }
}