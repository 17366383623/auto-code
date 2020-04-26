<?php


namespace AutoCode\Thinkphp\BaseModule\Entity;

use AutoCode\AbstractGenerator;
use AutoCode\DateBase\Table;
use AutoCode\MethodConfig;
use AutoCode\Utility\StringHelper;
use http\Exception\RuntimeException;
use Nette\PhpGenerator\Parameter;

/**
 * Class ModelEventGenerator
 * @package AutoCode\Thinkphp\BaseModule\Entity
 */
class ModelEventGenerator extends AbstractGenerator
{
    /**
     * @var Table $table
     */
    private Table $table;

    /**
     * @var array $useList
     */
    private array $useList = [];

    /**
     * ModelEventGenerator constructor.
     * @param Table $table
     */
     public function __construct(Table $table)
     {
         parent::__construct($table->getNamespace(), $table->getTableName(), $this->getUseList());
         $this->setTable($table);
     }

    /**
     * @return Table
     */
     public function getTable(): Table
     {
         return $this->table;
     }

    /**
     * @param Table $table
     */
     public function setTable(Table $table): void
     {
         $this->table = $table;
     }

    /**
     * @return array
     */
     public function getUseList(): array
     {
         return $this->useList;
     }

    /**
     * @param array $useList
     */
     public function setUseList(array $useList): void
     {
         $this->useList = $useList;
     }

    /**
     * create event function
     */
     public function createEvent(): void
     {
        $namespace = $this->table->getEventNamespace();
        $path = $this->table->getEventPath();
        if(!$namespace || !$path){
            throw new RuntimeException("createEventFunction path or namespace is null");
        }
        $event = $this->table->getEvent(FALSE);
        foreach ($event as $k => $v){
            $this->createEventMethod(ucfirst(StringHelper::camel($k)));
        }
     }

    /**
     * @param string $name
     */
     public function createEventMethod(string $name):void
     {
        $method = new MethodConfig($name);
        $method->setStatic();
        // 配置参数
        $param = new Parameter('col');
        $method->setParams();
     }
}