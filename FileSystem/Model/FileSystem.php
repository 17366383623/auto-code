<?php
namespace FileSystem\Model;

/**
 * 文件系统 model
 * Class FileSystem
 * @package AutoCode\FileSystem
 */
class FileSystem extends \think\Model
{
    /**
     * @var string 表名
     */
    protected $table = 'file_system';

    /**
     * @var string 主键id
     */
    protected $pk = 'id';

    /**
     * @var string 软删除
     */
    protected $deleteTime = 'delete_time';

    /**
     * @var int 软删除默认值
     */
    protected $defaultSoftDelete = 0;

    /**
     * @var string 更新时间
     */
    protected $updateTime = 'update_time';

    /**
     * @var string 创建时间
     */
    protected $createTime = 'create_time';

    /**
     * @var array 数据字段
     */
    protected $field = [
        'id', 'file_name', 'file_size', 'file_type', 'logic_path', 'real_path', 'create_time', 'update_time', 'delete_time'
    ];

    /**
     * @var array 类型转换
     */
    protected $type = [
        'id' => 'int',
        'file_size' => 'int',
        'create_time' => 'timestamp:Y-m-d H:i:s',
        'update_time' => 'timestamp:Y-m-d H:i:s'
    ];
}