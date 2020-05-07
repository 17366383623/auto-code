<?php


namespace AutoCode\Thinkphp;

use AutoCode\DateBase\DataBase;
use AutoCode\DateBase\Table;
use AutoCode\Thinkphp\BaseModule\Entity\EntityGenerator;
use AutoCode\Thinkphp\BaseModule\Model\ModelEventGenerator;
use AutoCode\Thinkphp\BaseModule\Model\ModelGenerator;
use AutoCode\Thinkphp\BaseModule\Service\ServiceGenerator;

/**
 * Class AutoRun
 * @package AutoCode\Thinkphp
 */
class AutoRun
{
    /**
     * @var array $config
     */
    private static $config = [
        // 数据库类型
        'db_engine' => 'InnoDB',
        // 创建数据库
        'create_db' => TRUE,
        // 创建基础服务
        'create_base_service' => TRUE,
        // 创建模型事件
        'create_model_event' => TRUE,
        // 创建基础模型
        'create_base_model' => TRUE,
        // 创建权限模块
        'create_permission' => FALSE,
        // 创建实体
        'create_entity' => TRUE,
        // 生成文件根路径
        'root_path' => '',
        // 文件根路径命名空间
        'root_namespace' => '',
        // 设置事件
        'event' => [
            'before_insert',
            'after_insert',
            'before_update',
            'after_update',
            'before_write',
            'after_write',
            'before_delete',
            'after_delete'
        ],
        // 自动写入时间戳字段
        'auto_timestamp' => 'create_at',
        // 软删除字段
        'soft_delete' => 'delete_at'
    ];

    /**
     * auto run
     * @param DataBase $database
     * @param array $config
     */
    public static function run(DataBase $database, array $config = []): void
    {
        self::$config = self::getConfig($config);
        self::createPhpFile($database);
    }

    /**
     * @param array $config
     * @return array
     */
    private static function getConfig(array $config = []): array
    {
        // 加载自定义配置
        if($config){
            return array_merge(self::$config, $config);
        }
        // 加载tp框架配置
        $config = config('auto-code');
        if(!isset($config)){
            $config = [];
        }
        return array_merge(self::config, $config);
    }

    /**
     * @param DataBase $database
     */
    private static function createPhpFile(DataBase $database):void
    {
        $tables = $database->getTables();
        foreach ($tables as $table){
            $table = self::setModelBaseConfig($table);
            // 创建模型基础对象
            if((bool)self::$config['create_base_model']){
                $modelGenerator = new ModelGenerator($table);
                $modelGenerator->create();
            }
            // 创建模型事件
            if((bool)self::$config['create_model_event']){
                $modelEvent = new ModelEventGenerator($table);
                $modelEvent->create();
            }
            // 创建模型实体
            if((bool)self::$config['create_entity']){
                $entity = new EntityGenerator($table);
                $entity->create();
            }
            // 创建基础类服务
            if((bool)self::$config['create_base_service']){
                $service = new ServiceGenerator($table);
                $service->create();
            }
        }
    }

    /**
     * 加载基础类模型生成器配置
     *
     * @param Table $table
     * @return Table
     */
    private static function setModelBaseConfig(Table $table):Table
    {
        $config = self::$config;
        // 设置根路径
        if(substr($config['root_path'], strlen($config['root_path'])-1, 1) !== '/'){
            $config['root_path'] .= '/';
        }
        $concurrentDirectory = $config['root_path'].'Model';
        if(!is_dir($concurrentDirectory) && !mkdir($concurrentDirectory = $config['root_path'].'Model') && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }
        $table->setPath($concurrentDirectory.'/');
        // 设置根命名空间
        if(strpos($config['root_namespace'], '\\') === 0){
            $config['root_namespace'] = substr($config['root_namespace'], 0, strlen($config['root_namespace'])-1);
        }
        $table->setNamespace($config['root_namespace'].'\\Model');
        // 设置服务创建
        if(isset($config['create_base_service']) && (bool)$config['create_base_service']){
            $serviceDirectory = $config['root_path'].'Service';
            if (!is_dir($serviceDirectory) && !mkdir($serviceDirectory) && !is_dir($serviceDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $serviceDirectory));
            }
            $concurrentDirectory = $serviceDirectory.'/'.ucfirst($table->getTableName());
            if (!is_dir($concurrentDirectory) && !mkdir($concurrentDirectory) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }
            $table->setServicePath($serviceDirectory.'/');
            $table->setServiceNamespace($config['root_namespace'].'\\Service');
        }
        // 设置模型事件创建
        if(isset($config['create_model_event']) && $config['create_model_event']){
            $eventDirectory = $config['root_path'].'Event';
            if (!is_dir($eventDirectory) && !mkdir($eventDirectory) && !is_dir($eventDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $eventDirectory));
            }
            $table->setEventPath($eventDirectory.'/');
            $table->setEventNamespace($config['root_namespace'].'\\Event');
        }
        // 设置实体创建
        if(isset($config['create_entity']) && $config['create_entity']){
            $entityDirectory = $config['root_path'].'Entity';
            if (!is_dir($entityDirectory) && !mkdir($entityDirectory) && !is_dir($entityDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $entityDirectory));
            }
            $table->setEntityPath($entityDirectory.'/');
            $table->setEntityNamespace($config['root_namespace'].'\\Entity');
        }
        $table->setEvent($config['event']);
        if(!$table->getAutoWriteTimestamp()){
            $table->setAutoWriteTimestamp($config['auto_timestamp']);
        }
        if(!$table->getSoftDelete()){
            $table->setSoftDelete($config['soft_delete']);
        }
        return $table;
    }
}