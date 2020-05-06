<?php


namespace AutoCode\Thinkphp\BaseModule\Model;

use AutoCode\AbstractGenerator;
use AutoCode\AccessControlType;
use AutoCode\DateBase\Table;
use AutoCode\MethodConfig;
use AutoCode\PhpFileGenerator;
use AutoCode\PhpType;
use AutoCode\Utility\FileSystem;
use AutoCode\Utility\StringHelper;
use http\Exception\RuntimeException;
use Nette\PhpGenerator\Parameter;

/**
 * Class ModelEventGenerator
 * @package AutoCode\Thinkphp\BaseModule\Entity
 */
class ModelEventGenerator extends AbstractGenerator implements PhpFileGenerator
{
    /**
     * @var Table $table
     */
    private $table;

    /**
     * @var array $useList
     */
    private $useList = [];

    /**
     * @var array $specialEvent
     */
    private $specialEvent = [
        'before_write',
        'before_insert',
        'before_update',
        'before_delete'
    ];

    /**
     * ModelEventGenerator constructor.
     * @param Table $table
     */
     public function __construct(Table $table)
     {
         parent::__construct($table->getEntityNamespace(), $table->getTableName(), $this->getUseList());
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
     public function create(): void
     {
        $table = $this->table;
        $namespace = $this->table->getEventNamespace();
        $this->setClassComment([
            'class '.StringHelper::snake($table->getTableName()),
            '@package '.$table->getNamespace()
        ]);
        $path = $this->table->getEventPath();
        if(!$namespace || !$path){
            throw new \RuntimeException('[error]: createEventFunction path or namespace is null');
        }
        $event = $this->table->getEvent();
        foreach ($event as $v){
            $this->createEventMethod(ucfirst(StringHelper::camel($v)));
        }
         FileSystem::createPhpFile($this->table->getEventPath(), StringHelper::camel(ucfirst($this->table->getTableName())), $this->dump());
     }

    /**
     * @param string $name
     * @throws \Exception
     */
     protected function createEventMethod(string $name):void
     {
        $method = new MethodConfig(lcfirst($name));
        $method->setStatic();
        // 配置参数
        $param = new Parameter('col');
        $method->setParams([$param]);
        $method->setAccessControl(AccessControlType::PUBLIC);
        $comment = [
            'event: '.$name,
            ' ',
            '@param mixed $col'
        ];
        if(in_array(StringHelper::snake(lcfirst($name)), $this->specialEvent, TRUE)){
            $comment[] = '@return boolean';
        }
        $method->setComment($comment);
        $bodyStr = '// do something when '.StringHelper::snake(lcfirst($name)).PHP_EOL;
        if(in_array(StringHelper::snake(lcfirst($name)), $this->specialEvent, TRUE)){
            $bodyStr .= 'return true;'.PHP_EOL;
            $method->setReturnType(PhpType::BOOLEAN);
        }
         $method->setBody($bodyStr);
        $this->addMethod($method);
     }
}