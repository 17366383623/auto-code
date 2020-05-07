<?php


namespace AutoCode\Thinkphp\BaseModule\Service;

use AutoCode\AccessControlType;
use AutoCode\DateBase\Table;
use AutoCode\MethodConfig;
use AutoCode\PhpFileGenerator;
use AutoCode\PhpType;
use Nette\PhpGenerator\Parameter;

class ServiceGenerator extends AbstractServiceGenerator implements PhpFileGenerator
{
    /**
     * @inheritDoc
     */
    protected function createInsertMethod(): void
    {
        // TODO: Implement createInsertMethod() method.
        $table = $this->getTable();
        $method = new MethodConfig('insert');
        $method->setComment([
            'insert',
            ' ',
            '@param array $insertArr',
            '@return int'
        ]);
        $method->setStatic();
        $method->setAccessControl(AccessControlType::PUBLIC);
        $method->setReturnType(PhpType::INTEGER);
        $param = new Parameter('insertArr');
        $param->setType('array');
        $param->setDefaultValue([]);
        $method->setParams([$param]);
        $bodyStr = '';
        $bodyStr .= 'if(!(bool)$insertArr){'.PHP_EOL;
        $bodyStr .= '  throw new \RuntimeException("insert array is null");'.PHP_EOL;
        $bodyStr .= '}'.PHP_EOL;
        $bodyStr .= '$model = \\'.$table->getNamespace().'\\'.ucfirst($table->getTableName()).'::create($insertArr);'.PHP_EOL;
        $bodyStr .= 'return (int)$model->id;';
        $method->setBody($bodyStr);
        $this->addMethod($method);
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    protected function createDeleteMethod(): void
    {
        // TODO: Implement createDeleteMethod() method.
        $table = $this->getTable();
        $method = new MethodConfig('delete');
        $method->setComment([
            'delete',
            ' ',
            '@param array $deleteArr',
            '@param bool $isDel',
            '@return bool'
        ]);
        $method->setStatic();
        $method->setAccessControl(AccessControlType::PUBLIC);
        $method->setReturnType(PhpType::BOOLEAN);
        $param = new Parameter('deleteArr');
        $param->setType('array');
        $del = new Parameter('isDel');
        $del->setDefaultValue(FALSE);
        $del->setType(PhpType::BOOLEAN);
        $method->setParams([$param, $del]);
        $bodyStr = 'if((bool)$isDel){'.PHP_EOL;
        $bodyStr .= '  return \\'.$table->getNamespace().'\\'.ucfirst($table->getTableName()).'::destroy($deleteArr, true);'.PHP_EOL;
        $bodyStr .= '}'.PHP_EOL;
        $bodyStr .= 'return \\'.$table->getNamespace().'\\'.ucfirst($table->getTableName()).'::destroy($deleteArr);';
        $method->setBody($bodyStr);
        $this->addMethod($method);
    }

    /**
     * @inheritDoc
     */
    protected function createEditMethod(): void
    {
        // TODO: Implement createEditMethod() method.
        $table = $this->getTable();
        $method = new MethodConfig('update');
        $method->setComment([
            'edit',
            ' ',
            '@param array $editArr',
            '@param array @whereArr',
            '@return array'
        ]);
        $method->setStatic();
        $method->setAccessControl(AccessControlType::PUBLIC);
        $method->setReturnType(PhpType::ARRAY);
        $param = new Parameter('editArr');
        $param->setType('array');
        $param_s = new Parameter('whereArr');
        $param_s->setType('array');
        $method->setParams([$param, $param_s]);
        $bodyStr = '';
        $bodyStr .= 'if(!(bool)$editArr){'.PHP_EOL;
        $bodyStr .= '  throw new \RuntimeException("[edit_error]: editArr array is null");'.PHP_EOL;
        $bodyStr .= '}'.PHP_EOL;
        $bodyStr .= 'if(!(bool)$whereArr){'.PHP_EOL;
        $bodyStr .= '  throw new \RuntimeException("[edit_error]: whereArr array is null");'.PHP_EOL;
        $bodyStr .= '}'.PHP_EOL;
        $bodyStr .= '$model = new \\'.$table->getNamespace().'\\'.ucfirst($table->getTableName()).'();'.PHP_EOL;
        $bodyStr .= '$model->save($editArr, $whereArr);'.PHP_EOL;
        $bodyStr .= 'return $model->toArray();';
        $method->setBody($bodyStr);
        $this->addMethod($method);
    }

    /**
     * @inheritDoc
     */
    protected function createTrashedMethod(): void
    {
        // TODO: Implement createTrashedMethod() method.
        $table = $this->getTable();
        if(!$table->getSoftDelete()) {
            return;
        }
        $method = new MethodConfig('queryTrash');
        $method->setComment([
            'get trashed data',
            ' ',
            '@param array $whereArr',
            '@return array'
        ]);
        $method->setStatic();
        $method->setAccessControl(AccessControlType::PUBLIC);
        $method->setReturnType(PhpType::ARRAY);
        $param = new Parameter('whereArr');
        $param->setType('array');
        $param->setDefaultValue([]);
        $method->setParams([$param]);
        $bodyStr = '';
        $bodyStr .= '$trashData = \\'.$table->getNamespace().'\\'.ucfirst($table->getTableName()).'::onlyTrashed(true)->select($whereArr);'.PHP_EOL;
        $bodyStr .= 'return is_array($trashData)?$trashData:(array)$trashData;';
        $method->setBody($bodyStr);
        $this->addMethod($method);
    }


    /**
     * @inheritDoc
     */
    protected function createRecoverMethod(): void
    {
        // TODO: Implement createRecoverMethod() method.
        $table = $this->getTable();
        $softDelStr = $table->getSoftDelete();
        if(!$softDelStr){
            return;
        }
        $method = new MethodConfig('Recover');
        $method->setComment([
            'recover from trashed',
            ' ',
            '@param array $whereArr',
            '@return bool'
        ]);
        $method->setStatic();
        $method->setAccessControl(AccessControlType::PUBLIC);
        $method->setReturnType(PhpType::BOOLEAN);
        $param = new Parameter('whereArr');
        $param->setType('array');
        $method->setParams([$param]);
        $bodyStr = '';
        $bodyStr .= 'return (bool)\\'.$table->getNamespace().'\\'.ucfirst($table->getTableName()).'::update(["'.$softDelStr.'" => ""], $whereArr);';
        $method->setBody($bodyStr);
        $this->addMethod($method);
    }
}