<?php

namespace App\Repositories\Base;

use \Darkness\Repository\BaseRepository as Repository;

abstract class BaseRepository extends Repository implements BaseRepositoryInterface
{
    public function findByQuery($shop, $params = [], $selects = "*")
    {
        return $this->model
            ->select($selects)
            ->shop($shop)
            ->when(!empty($params), function ($query) use ($params) {
                foreach ($params as $key => $param) {
                    is_object($param) && $param = $param->toArray();
                    if (is_array($param)) {
                        $query->whereIn($key, $param);
                    } else {
                        $query->where($key, $param);
                    }
                }
            })
            ->get();
    }

	public function updateOrCreate(array $condition, array $data)
	{
		return $this->model->updateOrCreate($condition, $data);
	}
}
