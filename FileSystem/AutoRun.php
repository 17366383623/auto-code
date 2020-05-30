<?php
namespace FileSystem;

use AutoCode\Auto\Utility\Generic\PropertyGeneric;
use AutoCode\Auto\Utility\Property;
use AutoCode\DataBase\DataBaseGeneric\TableGeneric;
use AutoCode\DataBase\SqlElementObject\Column;
use AutoCode\DataBase\SqlElementObject\DataBase;
use AutoCode\DataBase\SqlElementObject\Table;
use AutoCode\DataBase\Utility\SqlGenerator;
use AutoCode\DataBase\Utility\SqlTypeEnum;

/**
 * 初始化类
 * Class AutoRun
 * @package AutoCode\FileSystem
 */
class AutoRun
{
    /**
     * AutoRun constructor.
     * @param string $prefix
     */
    public function __construct(string $prefix)
    {
        $this->createSqlTable($prefix);
    }

    /**
     * 创建数据库
     * @param string $prefix
     */
    private function createSqlTable(): void
    {
        $table = new Table('file_system', './', 'app');
        $propertyGeneric = new PropertyGeneric();
        // 主键id
        $idColumn = new Column('id', SqlTypeEnum::__INTEGER__, '11');
        $idColumn->setAutoIncrement();
        $idColumn->setIsPrimary();
        $idColumn->setComment('主键id');
        $id = new Property($idColumn);
        $propertyGeneric->push($id);
        // 文件名称
        $fileName = new Property(new Column('file_name', SqlTypeEnum::__VARCHAR__, '30', '文件名称'));
        $propertyGeneric->push($fileName);
        // 文件尺寸
        $fileSize = new Property(new Column('file_size', SqlTypeEnum::__DECIMAL__, '11,2', '文件尺寸(MB)'));
        $propertyGeneric->push($fileSize);
        // 文件类型
        $fileType = new Property(new Column('file_type', SqlTypeEnum::__VARCHAR__, '50', '文件类型'));
        $propertyGeneric->push($fileType);
        // 文件逻辑路径
        $fileLogicPath = new Property(new Column('logic_path', SqlTypeEnum::__VARCHAR__, '255', '文件逻辑路径'));
        $propertyGeneric->push($fileLogicPath);
        // 文件绝对路径
        $fileRealPath = new Property(new Column('real_path', SqlTypeEnum::__VARCHAR__, '255', '文件绝对路径'));
        $propertyGeneric->push($fileRealPath);
        // 创建时间
        $createTime = new Property(new Column('create_time', SqlTypeEnum::__DATETIME__, '6', '创建时间'));
        $propertyGeneric->push($createTime);
        // 更新时间
        $updateTime = new Property(new Column('update_time', SqlTypeEnum::__DATETIME__, '6', '修改时间'));
        $propertyGeneric->push($updateTime);
        // 软删除
        $softDelete = new Column('delete_time', SqlTypeEnum::__INTEGER__, '2', '软删除');
        $softDelete->setDefaultValue(0);
        $deleteTime = new Property($softDelete);
        $propertyGeneric->push($deleteTime);
        $table->setPropertyGeneric($propertyGeneric);
        $tableGeneric = new TableGeneric();
        $tableGeneric->push($table);
        $database = new DataBase('database');
        $database->setTables($tableGeneric);
        var_dump(SqlGenerator::handle($database));die;
        // Db::execute(SqlGenerator::handle($database));
    }
}