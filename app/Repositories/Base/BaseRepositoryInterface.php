<?php

namespace App\Repositories\Base;

use \Darkness\Repository\BaseRepositoryInterface as RepositoryInterface;
interface BaseRepositoryInterface extends RepositoryInterface
{
    public function findByQuery($shop, $params = [], $selects = "*");
    public function updateOrCreate(array $condition, array $data);
}
