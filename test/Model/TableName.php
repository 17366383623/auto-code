<?php
namespace Test\Model;

/**
 * class table_name
 * @package Test\Model
 */
class TableName extends \think\Model
{
    use \traits\model\SoftDelete;

    /**
     * 数据类型转换
     *
     * @var array
     */
    public string $type = ['test_pro' => 'string'];

    /**
     * auto timestamp
     *
     * @var string
     */
    protected string $autoWriteTimestamp = 'create_at';

    /**
     * set soft_delete
     *
     * @var string
     */
    protected string $deleteTime = 'delete_at';

    /**
     * event config
     *
     * @return void
     */
    protected static function init(): void
    {
        self::beforeInsert(\Test\Event\TableName::beforeInsert);
        self::afterInsert(\Test\Event\TableName::afterInsert);
        self::beforeUpdate(\Test\Event\TableName::beforeUpdate);
        self::afterUpdate(\Test\Event\TableName::afterUpdate);
        self::beforeWrite(\Test\Event\TableName::beforeWrite);
        self::afterWrite(\Test\Event\TableName::afterWrite);
        self::beforeDelete(\Test\Event\TableName::beforeDelete);
        self::afterDelete(\Test\Event\TableName::afterDelete);
    }
}
