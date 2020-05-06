<?php
namespace Test\Service;

class TableNameBaseService
{
    /**
     * insert
     *
     * @param array $insertArr
     * @return int
     */
    public function insert(array $insertArr = []): int
    {
        if(!(bool)$insertArr){
          throw new \RuntimeException("insert array is null");
        }
        $model = \Test\Model\TableName::create($insertArr);
        return (int)$model->id;
    }

    /**
     * delete
     *
     * @param array $deleteArr
     * @param bool $isDel
     * @return bool
     */
    public function delete(array $deleteArr, bool $isDel = false): bool
    {
        if((bool)$isDel){
          return \Test\Model\TableName::destroy($deleteArr, true);
        }
        return \Test\Model\TableName::destroy($deleteArr);
    }

    /**
     * edit
     *
     * @param array $editArr
     * @param array @whereArr
     * @return array
     */
    public function update(array $editArr, array $whereArr): array
    {
        if(!(bool)$editArr){
          throw new \RuntimeException("[edit_error]: editArr array is null");
        }
        if(!(bool)$whereArr){
          throw new \RuntimeException("[edit_error]: whereArr array is null");
        }
        $model = new \Test\Model\TableName();
        $model->save($editArr, $whereArr);
        return $model;
    }

    /**
     * get trashed data
     *
     * @param array $whereArr
     * @return array
     */
    public function queryTrash(array $whereArr = []): array
    {
        $trashData = \Test\Model\TableName::onlyTrashed(true)->select($whereArr);
        return is_array($trashData)?$trashData:(array)$trashData;
    }

    /**
     * recover from trashed
     *
     * @param array $whereArr
     * @return bool
     */
    public function Recover(array $whereArr): bool
    {
        return (bool)\Test\Model\TableName::update(["delete_at" => ""], $whereArr);
    }
}
