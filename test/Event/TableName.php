<?php
namespace Test\Entity;

/**
 * class table_name
 * @package Test\Model
 */
class TableName
{
    /**
     * event: BeforeInsert
     *
     * @param mixed $col
     * @return boolean
     */
    public static function beforeInsert($col): bool
    {
        // do something when before_insert
        return true;
    }

    /**
     * event: AfterInsert
     *
     * @param mixed $col
     */
    public static function afterInsert($col)
    {
        // do something when after_insert
    }

    /**
     * event: BeforeUpdate
     *
     * @param mixed $col
     * @return boolean
     */
    public static function beforeUpdate($col): bool
    {
        // do something when before_update
        return true;
    }

    /**
     * event: AfterUpdate
     *
     * @param mixed $col
     */
    public static function afterUpdate($col)
    {
        // do something when after_update
    }

    /**
     * event: BeforeWrite
     *
     * @param mixed $col
     * @return boolean
     */
    public static function beforeWrite($col): bool
    {
        // do something when before_write
        return true;
    }

    /**
     * event: AfterWrite
     *
     * @param mixed $col
     */
    public static function afterWrite($col)
    {
        // do something when after_write
    }

    /**
     * event: BeforeDelete
     *
     * @param mixed $col
     * @return boolean
     */
    public static function beforeDelete($col): bool
    {
        // do something when before_delete
        return true;
    }

    /**
     * event: AfterDelete
     *
     * @param mixed $col
     */
    public static function afterDelete($col)
    {
        // do something when after_delete
    }
}
