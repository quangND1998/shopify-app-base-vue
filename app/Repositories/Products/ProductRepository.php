<?php

namespace App\Repositories\Products;

use App\Repositories\Base\BaseRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;


class ProductRepository extends BaseRepository
{

    /**
     * Product model.
     * @var Model
     */
    protected $model;


    /**
     * ProductRepository constructor.
     * @param Product $product
     */
    public function __construct(
        Product $product
    ) {
        $this->model = $product;
    }
}
