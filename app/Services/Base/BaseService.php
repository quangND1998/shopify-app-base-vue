<?php

namespace App\Services\Base;

use Darkness\Repository\BaseRepository;

abstract class BaseService implements BaseServiceInterface
{
    protected $repository;

    protected function getRepository()
    {
        return $this->repository;
    }

    public function getInstance($object)
    {
        if (is_a($object, get_class($this->getRepository()))) {
            return $object;
        } else {
            return $this->getById($object);
        }
    }

    public function getByQuery($params = [], $size = 25)
    {
        return $this->getRepository()->getByQuery($params, $size);
    }

    public function getById($id)
    {
        return $this->getRepository()->getById($id);
    }

    public function getByIdInTrash($id)
    {
        return $this->getRepository()->getByIdInTrash($id);
    }

    public function store(array $data)
    {
        return $this->getRepository()->store($data);
    }

    public function storeArray(array $datas)
    {
        return $this->getRepository()->storeArray($datas);
    }

    public function update($id, array $data, array $excepts = [], array $only = [])
    {
        return $this->getRepository()->update($id, $data,$excepts,$only);
    }

    public function delete($id)
    {
        return $this->getRepository()->delete($id);
    }

    public function destroy($id)
    {
        return $this->getRepository()->destroy($id);
    }

    public function restore($id)
    {
        return $this->getRepository()->restore($id);
    }
}
