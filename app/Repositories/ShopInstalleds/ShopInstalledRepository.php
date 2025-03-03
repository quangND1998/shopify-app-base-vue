<?php

namespace App\Repositories\ShopInstalleds;

use App\Repositories\ShopInstalleds\ShopInstalled;
use QuangND\Shopify\Repositories\ShopInstalleds\ShopInstalledRepository as BaseRepository;

class ShopInstalledRepository extends BaseRepository
{
    protected $model;
    public function __construct(ShopInstalled $shopInstalled)
    {
        parent::__construct($shopInstalled);
        $this->model = $shopInstalled;
    }

    public function getByShop($shop)
    {
        return $this->model->where('shop', $shop)->where('app_id', env('APP_ID'))->first();
    }
}
