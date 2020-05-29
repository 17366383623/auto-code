<?php


namespace AutoCode\Auto\Thinkphp;

use AutoCode\Auto\Thinkphp\Service\DeleteServiceGenerator;
use AutoCode\Auto\Thinkphp\Service\InsertServiceGenerator;
use AutoCode\Auto\Thinkphp\Service\SearchPaginateServiceGenerator;
use AutoCode\Auto\Thinkphp\Service\SearchServiceGenerator;
use AutoCode\Auto\Thinkphp\Service\TrashedServiceGenerator;
use AutoCode\Auto\Thinkphp\Service\UpdateServiceGenerator;
use AutoCode\DataBase\SqlElementObject\DataBase;
use AutoCode\DataBase\Utility\SqlGenerator;
use think\Db;

/**
 * Class AutoRun
 * @package AutoCode\Auto\Thinkphp
 */
class AutoRun
{
    /**
     * @var DataBase
     */
    private $database;

    /**
     * AutoRun constructor.
     * @param DataBase $database
     * @param bool $createSql
     */
    public function __construct(DataBase $database, bool $createSql = false)
    {
        $this->setDatabase($database);
        $this->run();
        if ($createSql) {
            $this->createDataBase($database);
        }
        echo '创建完成!'.PHP_EOL;
    }

    /**
     * @param DataBase $database
     */
    public function setDatabase(DataBase $database): void
    {
        $this->database = $database;
    }

    /**
     * 创建自动文件
     */
    private function run(): void
    {
        foreach ($this->database->getTables() as $table) {
            // 生成模型
            new \AutoCode\Auto\Thinkphp\Model\ModelGenerator($table, $this->database);
            // 生成验证器
            new \AutoCode\Auto\Thinkphp\Validate\ValidateGenerator($table);
            // 批量查询服务
            new SearchServiceGenerator($table);
            // 分页查询服务
            new SearchPaginateServiceGenerator($table);
            // 生成插入服务
            new InsertServiceGenerator($table);
            // 生成更新服务
            new UpdateServiceGenerator($table);
            // 生成删除服务
            new DeleteServiceGenerator($table);
            // 生成垃圾查询服务
            new TrashedServiceGenerator($table);
        }
    }

    /**
     * 创建数据库
     * @param DataBase $database
     */
    private function createDataBase(DataBase $database): void
    {
        var_dump(SqlGenerator::handle($database));
        // Db::execute(SqlGenerator::handle($database));
    }
}