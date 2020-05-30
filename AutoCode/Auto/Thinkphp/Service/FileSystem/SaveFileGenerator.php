<?php

namespace AutoCode\Auto\Thinkphp\Service\FileSystem;

use AutoCode\Auto\Thinkphp\ServiceGenerator;
use AutoCode\Auto\Utility\Enum\PhpType;
use AutoCode\Auto\Utility\Generic\MethodGeneric;
use AutoCode\Auto\Utility\Generic\ParamGeneric;
use AutoCode\Auto\Utility\Generic\PropertyGeneric;
use AutoCode\Auto\Utility\Method;
use AutoCode\Common\StringHelper;
use AutoCode\DataBase\SqlElementObject\Table;
use Nette\PhpGenerator\Parameter;

/**
 * 保存文件
 * Class SaveFileGenerator
 * @package AutoCode\Auto\Thinkphp\Service\FileSystem
 */
class SaveFileGenerator extends ServiceGenerator
{
    /**
     * InsertServiceGenerator constructor.
     * @param Table $table
     */
    public function __construct(Table $table)
    {
        parent::__construct($this->getNamespace($table), ucfirst(StringHelper::camel($table->getName())).'SaveService', $this->getRootPath($table), $this->createProperty($table), $this->createMethod($table), $table->getComment());
    }

    /**
     * 创建写入方法
     * @param Table $table
     * @return MethodGeneric
     */
    private function createMethod(Table $table): MethodGeneric
    {
        $pk = $this->getPk($table);
        $methodContainer = new MethodGeneric();
        // 参数一
        $param = new Parameter('fileName');
        $param->setType(PhpType::__STRING__);
        // 参数二
        $logicPath = new Parameter('logicPath');
        $logicPath->setType(PhpType::__STRING__);
        // 参数三
        $realPath = new Parameter('realPath');
        $realPath->setType(PhpType::__STRING__);
        $paramGeneric = new ParamGeneric();
        $paramGeneric->push($param);
        $paramGeneric->push($logicPath);
        $paramGeneric->push($realPath);
        $content = '
        $file = request()->file($fileName);
        if (!is_dir($realPath) && !mkdir($realPath) && !is_dir($realPath)) {
            throw new \RuntimeException("$realPath is not a valid path");
        }
        if ($movedFile = $file->move($realPath)) {
            if($realPath[strlen($realPath) - 1] === \'/\') {
                $realPath = substr($realPath, 0, -1);
            }
            $realPath       .= \'/\'.$movedFile->getExtension();
            $uploadFileInfo = $movedFile->getInfo();
            $fileName       = $uploadFileInfo[\'name\'];
            $fileType       = $uploadFileInfo[\'type\'];
            $size           = $uploadFileInfo[\'size\'];
            $saveArr        = [
                \'file_name\'  => $fileName,
                \'file_type\'  => $fileType,
                \'file_size\'  => $size,
                \'real_path\'  => $realPath,
                \'logic_path\' => $logicPath
            ];
            return \\'.$table->getRootNamespace().'\\Model\\'.ucfirst(StringHelper::camel($table->getName())).'::create($saveArr)->'.$pk.';
        }
        throw new \RuntimeException(\'file move error\');';
        $method = $this->handleMethod($paramGeneric, '保存文件', $content, PhpType::__INTEGER__);
        $methodContainer->push($method);
        return $methodContainer;
    }

    /**
     * @param Table $table
     * @return PropertyGeneric
     */
    private function createProperty(Table $table): PropertyGeneric
    {
        return new PropertyGeneric();
    }
}